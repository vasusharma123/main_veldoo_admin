<?php

namespace App\Http\Controllers;

use Config;
use App\Category;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\VehicleReportExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Vehicle;
use App\Exports\VehicleMileageReportExport;


class DailyReportController extends Controller
{
    public function __construct()
    {
        //$this->table = 'categories';
        $this->folder = 'daily_report';
        view()->share('route', 'daily-report');
        $this->limit = Config::get('limit');
    }
    public function index(Request $request)
    {
        $breadcrumb = array('title' => 'Daily Report', 'action' => 'Daily Report');
        $data = [];
        $data['daily_rides_count'] = \App\Ride::whereDate('ride_time', Carbon::now()->format('Y-m-d'))->count();
        $data['driver_count'] = \App\User::where('user_type', 2)->whereDate('created_at', Carbon::now()->format('Y-m-d'))->count();
        $data['rider_count'] = \App\User::where('user_type', 1)->whereDate('created_at', Carbon::now()->format('Y-m-d'))->count();
        $data['company_registered'] = 0;
        $data['i'] = (($request->input('page', 1) - 1) * $this->limit);
        $data['orderby'] = $request->input('orderby');
        $data['order'] = $request->input('order');
        $data = array_merge($breadcrumb, $data);
        /* if ($request->ajax()) {
            return view("admin.{$this->folder}.index_element")->with($data);
        }*/
        return view("admin.{$this->folder}.index")->with($data);
    }

    public function vehicles(Request $request)
    {
        $vehicles = Vehicle::select('id', 'vehicle_number_plate', 'model', 'year')->orderBy('id', 'DESC')->get();
        return view("admin.daily_report.vehicles")->with(['title' => 'Vehicle Report', 'action' => '', 'vehicles' => $vehicles]);
    }

    public function vehicle_export(Request $request)
    {
        $rules = [
            'start_date' => 'required',
            'end_date' => 'required',
            'vehicle_id' => 'required'
        ];
        $request->validate($rules);
        $input = $request->all();
        if (strtotime($request->start_date) > strtotime($request->end_date)) {
            return back()->with("warning", "End Date must be greater than start date");
        }
        return Excel::download(new VehicleReportExport($input), 'Vehicle List Veldoo.xlsx');
    }

    public function vehicle_mileage(Request $request)
    {
        return view("admin.daily_report.vehicle_mileage")->with(['title' => 'Vehicles Mileage Report', 'action' => '']);
    }

    public function vehicle_mileage_export(Request $request)
    {
        $rules = [
            'start_date' => 'required',
            'end_date' => 'required'
        ];
        $request->validate($rules);
        $input = $request->all();
        if (strtotime($request->start_date) > strtotime($request->end_date)) {
            return back()->with("warning", "End Date must be greater than start date");
        }
        return Excel::download(new VehicleMileageReportExport($input), 'Vehicle Mileage Veldoo.xlsx');
    }
}
