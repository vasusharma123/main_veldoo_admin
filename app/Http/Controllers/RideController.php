<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ride;
use DataTables;
use App\User;

class RideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = array();
        $data = array('title' => 'Ride', 'action' => 'Ride Lists');


        if ($request->ajax()) {

            $data = Ride::select(['rides.id', 'rides.user_id', 'rides.pickup_address', 'rides.dest_address', 'rides.ride_time', 'rides.distance', 'rides.status', 'rides.note', 'rides.ride_cost', 'users.first_name', 'users.last_name', 'vehicles.vehicle_number_plate', 'prices.seating_capacity', 'payment_methods.name AS payment_name'])
                ->leftJoin('users', 'users.id', 'rides.driver_id')
                ->leftJoin('vehicles', 'vehicles.id', 'rides.vehicle_id')
                ->leftJoin('prices', function ($join) {
                    $join->on('vehicles.category_id', '=', 'prices.id')->where('prices.deleted_at', null);
                })
                ->leftJoin('payment_methods', 'payment_methods.id', 'rides.payment_type')
                ->orderBy('rides.id', 'DESC')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->status == 0) {
                        $status = '<label class="badge badge-info">Process</label>';
                    } elseif ($row->status == 1) {
                        $status = '<label class="badge badge-warning">Accepted By Driver</label>';
                    } elseif ($row->status == 2) {
                        $status = '<label class="badge badge-info">Ride Start</label>';
                    } elseif ($row->status == 3) {
                        $status = '<label class="badge badge-success">Completed </label>';
                    } else if ($row->status == 4) {
                        $status = '<label class="badge badge-info">Driver Reached To Customer </label>';
                    } else if ($row->status == -2) {
                        $status = '<label class="badge badge-danger">Cancelled</label>';
                    } else if ($row->status == -4 or $row->status == 5) {
                        $status = '<label class="badge badge-warning">Pending</label>';
                    }
                    return $status;
                })->addColumn('driver', function ($row) {
                    return ucfirst($row->first_name . ' ' . $row->last_name);
                })->addColumn('guest', function ($row) {
                    $users = User::where('id', $row->user_id)->first();
                    return ($users) ? ucfirst($users->first_name . ' ' . $users->last_name) : '';
                    // })->addColumn('week', function ($row) {
                    //     return date("W", strtotime($row->ride_time));
                })->addColumn('date', function ($row) {
                    return date('d/m/Y', strtotime($row->ride_time));
                    // })->addColumn('day', function ($row) {
                    //     return date('l', strtotime($row->ride_time));
                })->addColumn('car', function ($row) {
                    return ucfirst($row->vehicle_number_plate);
                })->addColumn('seat_capacity', function ($row) {
                    return ucfirst($row->seating_capacity);
                })->addColumn('pick_up', function ($row) {
                    return ucfirst($row->pickup_address);
                })->addColumn('drop_off', function ($row) {
                    return ucfirst($row->dest_address);
                })->addColumn('distance', function ($row) {
                    return ucfirst($row->distance);
                })->addColumn('cash', function ($row) {
                    return 0;
                    // })->addColumn('comment', function ($row) {
                    //     return ucfirst($row->note);
                })->addColumn('payment', function ($row) {
                    return ucfirst($row->payment_name);
                })->addColumn('ride_cost', function ($row) {
                    return number_format($row->ride_cost, 2);
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group dropright">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('bookings.show', $row->id) . '">' . trans("admin.View") . '</a>
                        </div>
                    </div>';
                    return $btn;
                })
                ->rawColumns(['action', 'status', 'driver', 'date', 'car', 'seat_capacity', 'pick_up', 'drop_off', 'distance', 'cash', 'guest', 'payment', 'ride_cost'])
                ->make(true);
        }
        return view('admin.rides.index')->with($data);
    }
}
