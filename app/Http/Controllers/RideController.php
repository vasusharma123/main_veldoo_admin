<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ride;
use App\RideHistory;
use DataTables;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Exports\RideV1Export;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class RideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = array('title' => 'Ride', 'action' => 'Ride Lists');
        $rides = Ride::select(['rides.id', 'rides.user_id', 'rides.pickup_address', 'rides.dest_address', 'rides.ride_time', 'rides.distance', 'rides.status', 'rides.note', 'rides.ride_cost', 'rides.payment_type', 'users.first_name', 'users.last_name','guest.first_name as guest_first_name', 'guest.last_name as guest_last_name', 'vehicles.vehicle_number_plate', 'prices.seating_capacity', 'payment_methods.name AS payment_name'])
                ->leftJoin('users', 'users.id', 'rides.driver_id')
                ->leftJoin('users as guest', 'guest.id', 'rides.user_id')
                ->leftJoin('vehicles', 'vehicles.id', 'rides.vehicle_id')
                ->leftJoin('prices', function ($join) {
                    $join->on('vehicles.category_id', '=', 'prices.id')->where('prices.deleted_at', null);
                })
                ->leftJoin('payment_methods', 'payment_methods.id', 'rides.payment_type')
                ->orderBy('rides.id', 'DESC');
        if ($request->has('search') && !empty($request->search)) {
            $rides->where(function($query) use ($request){
                $query->orWhere('rides.id','LIKE','%'.$request->search.'%');
                // $query->orWhere('users.first_name','LIKE','%'.$request->search.'%');
                // $query->orWhere('users.last_name','LIKE','%'.$request->search.'%');
                $query->orWhereRaw("CONCAT(`users`.`first_name`,' ',`users`.`last_name`) LIKE '%".$request->search."%'");
                $query->orWhereRaw("CONCAT(`guest`.`first_name`,' ',`guest`.`last_name`) LIKE '%".$request->search."%'");
                // $query->orWhere('guest.last_name','LIKE','%'.$request->search.'%');
                $query->orWhere('vehicles.vehicle_number_plate','LIKE','%'.$request->search.'%');
                $query->orWhere('rides.pickup_address','LIKE','%'.$request->search.'%');
                $query->orWhere('rides.dest_address','LIKE','%'.$request->search.'%');
                $query->orWhere('payment_type','LIKE','%'.$request->search.'%');
            });
        }
        $data['start_date'] = "";
        $data['end_date'] = "";
        if (($request->has('start_date') && !empty($request->start_date)) && ($request->has('end_date') && !empty($request->end_date))) {
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date);
            $endDate = Carbon::createFromFormat('d/m/Y', $request->end_date);
            $rides->whereRaw('date(ride_time) between date("'.$startDate.'") and date("'.$endDate.'")');
        }
        $data['rides'] = $rides->paginate(100);
        // if ($request->ajax()) {

        //     $data = Ride::select(['rides.id', 'rides.user_id', 'rides.pickup_address', 'rides.dest_address', 'rides.ride_time', 'rides.distance', 'rides.status', 'rides.note', 'rides.ride_cost', 'rides.payment_type', 'users.first_name', 'users.last_name', 'vehicles.vehicle_number_plate', 'prices.seating_capacity', 'payment_methods.name AS payment_name'])
        //         ->leftJoin('users', 'users.id', 'rides.driver_id')
        //         ->leftJoin('vehicles', 'vehicles.id', 'rides.vehicle_id')
        //         ->leftJoin('prices', function ($join) {
        //             $join->on('vehicles.category_id', '=', 'prices.id')->where('prices.deleted_at', null);
        //         })
        //         ->leftJoin('payment_methods', 'payment_methods.id', 'rides.payment_type')
        //         ->orderBy('rides.id', 'DESC');

        //     return Datatables::of($data)
        //         ->addIndexColumn()
        //         ->addColumn('status', function ($row) {
        //             if ($row->status == 0) {
        //                 $status = '<label class="badge badge-info">Process</label>';
        //             } elseif ($row->status == 1) {
        //                 $status = '<label class="badge badge-warning">Accepted By Driver</label>';
        //             } elseif ($row->status == 2) {
        //                 $status = '<label class="badge badge-info">Ride Start</label>';
        //             } elseif ($row->status == 3) {
        //                 $status = '<label class="badge badge-success">Completed </label>';
        //             } else if ($row->status == 4) {
        //                 $status = '<label class="badge badge-info">Driver Reached To Customer </label>';
        //             } else if ($row->status == -2) {
        //                 $status = '<label class="badge badge-danger">Cancelled</label>';
        //             } else if ($row->status == -4 or $row->status == 5) {
        //                 $status = '<label class="badge badge-warning">Pending</label>';
        //             } else if ($row->status == -3) {
        //                 $status = '<label class="badge badge-danger">Cancelled By Customer</label>';
        //             } else {
        //                 $status = "";
        //             }
        //             return $status;
        //         })->addColumn('driver', function ($row) {
        //             return ucfirst($row->first_name . ' ' . $row->last_name);
        //         })->addColumn('guest', function ($row) {
        //             $users = User::where('id', $row->user_id)->first();
        //             return ($users) ? ucfirst($users->first_name . ' ' . $users->last_name) : '';
        //             // })->addColumn('week', function ($row) {
        //             //     return date("W", strtotime($row->ride_time));
        //         })->addColumn('date', function ($row) {
        //             return date('d/m/Y', strtotime($row->ride_time));
        //             // })->addColumn('day', function ($row) {
        //             //     return date('l', strtotime($row->ride_time));
        //         })->addColumn('car', function ($row) {
        //             return ucfirst($row->vehicle_number_plate);
        //         })->addColumn('seat_capacity', function ($row) {
        //             return ucfirst($row->seating_capacity);
        //         })->addColumn('pick_up', function ($row) {
        //             return ucfirst($row->pickup_address);
        //         })->addColumn('drop_off', function ($row) {
        //             return ucfirst($row->dest_address);
        //         })->addColumn('distance', function ($row) {
        //             return ucfirst($row->distance);
        //         })->addColumn('cash', function ($row) {
        //             return 0;
        //             // })->addColumn('comment', function ($row) {
        //             //     return ucfirst($row->note);
        //         })->addColumn('payment', function ($row) {
        //             return ucfirst($row->payment_type);
        //         })->addColumn('ride_cost', function ($row) {
        //             return number_format($row->ride_cost, 2);
        //         })
        //         ->addColumn('checkboxes', function ($row) {
        //             $btn = '<label class="custom-control custom-checkbox">
        //                         <input type="checkbox" data-id="' . $row->id . '" class="custom-control-input editor-active">
        //                         <span class="custom-control-label"></span>
        //                     </label>';
        //             return $btn;
        //         })
        //         ->addColumn('action', function ($row) {
        //             $btn = '<div class="btn-group dropright">
        //                 <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        //                     Action
        //                 </button>
        //                 <div class="dropdown-menu">
        //                     <a class="dropdown-item" href="' . route('bookings.show', $row->id) . '">' . trans("admin.View") . '</a>
        //                     <a class="dropdown-item delete_record" data-id="' . $row->id . '">' . trans("admin.Delete") . '</a>
        //                 </div>
        //             </div>';
        //             return $btn;
        //         })
        //         ->rawColumns(['action', 'status', 'driver', 'date', 'car', 'seat_capacity', 'pick_up', 'drop_off', 'distance', 'cash', 'guest', 'payment', 'ride_cost', 'checkboxes'])
        //         ->make(true);
        // }
        return view('admin.rides.index')->with($data);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            Ride::where(['id' => $id])->delete();
            RideHistory::where(['ride_id' => $id])->delete();
            DB::commit();
            return response()->json(['status' => 1, 'message' => "Ride has been deleted."], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 0, 'message' => $e->getMessage()], 400);
        }
    }

    public function rideExport(Request $request)
    {
        
        return Excel::download(new RideV1Export($request->all()), 'Rides List Veldoo.xlsx');
    }

    public function delete_multiple(Request $request)
    {
        $rules = [
            'selected_ids' => 'required|array'
        ];
        $messages = [
            'selected_ids.required' => "Select atleast one checkbox"
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()]);
        }
        try {
            DB::beginTransaction();
            Ride::whereIn('id', $request->selected_ids)->delete();
            RideHistory::whereIn('ride_id', $request->selected_ids)->delete();
            DB::commit();
            return response()->json(['status' => 1, 'message' => "Selected rides are deleted."], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 0, 'message' => $e->getMessage()], 400);
        }
    }
}
