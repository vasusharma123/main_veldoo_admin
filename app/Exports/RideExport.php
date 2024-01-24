<?php

namespace App\Exports;

use App\Ride;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RideExport implements FromCollection, WithHeadings
{
    protected $from_date;
    protected $to_date;
    protected $req_params;
	
	public function __construct($req_params=array()) 
    {
        $this->from_date = $req_params['start_date'];
        $this->to_date = $req_params['end_date'];
        $this->req_params = $req_params;
    }
	
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if(Auth::user()->user_type == 8){
            $sp_id = Auth::user()->service_provider_id;
        }elseif(Auth::user()->user_type == 3){
            $sp_id = Auth::user()->id;
        }else{
            $sp_id = Auth::user()->id;
        }
		$from_date = $this->from_date;
		$to_date = $this->to_date;
        $req_params = $this->req_params;
		
		$records = Ride::with(['driver', 'user', 'vehicle']);
        $records = $records->whereDate('ride_time', '>=', $from_date)->whereDate('ride_time', '<=', $to_date);
        if(!empty($this->req_params['selected_ride'])){
            $records = $records->whereIn('id',$this->req_params['selected_ride']);
        }
        if(!empty($req_params['search'])){
            $records = $records->where(function ($query) use ($req_params) {
                $query->where('pickup_address', 'like', '%' . $req_params['search'] . '%');
                $query->orWhereHas('driver', function($query1) use ($req_params) {
                    $query1->where(DB::raw('CONCAT_WS(" ", first_name, last_name)'), 'like', '%' . $req_params['search'] . '%');
                });
                $query->orWhereHas('user', function($query1) use ($req_params) {
                    $query1->where(DB::raw('CONCAT_WS(" ", first_name, last_name)'), 'like', '%' . $req_params['search'] . '%');
                });
                $query->orWhereHas('company', function($query1) use ($req_params) {
                    $query1->where('name', 'like', '%' . $req_params['search'] . '%');
                });
            });
        }
        $records = $records->where(['service_provider_id' => $sp_id])->orderBy('id', 'desc')->get();
		
		$rideStatus = ['0' => "Process", '1' => "Accepted By Driver", '2' => "Ride Start", '3' => "Completed", '4' => "Driver Reached To Customer", '-2' => "Cancelled", '-4' => "Pending"];
		
		$result = array();
        foreach($records as $record){
           $result[] = array(
              'id'=>$record->id,
              'date'=>date('d M, Y H:i:s', strtotime($record->ride_time)),
              'driver_name' => (!empty($record->driver->first_name) ? $record->driver->first_name . ' ' . $record->driver->last_name : ''),
              'vehicle' => (!empty($record->vehicle->vehicle_number_plate) ? $record->vehicle->vehicle_number_plate : ''),
              'user' => (!empty($record->user->first_name) ? $record->user->first_name. ' ' . $record->user->last_name : ''),
              'pickup_address' => $record->pickup_address,
              'dest_address' => $record->dest_address,
              'distance' => $record->distance,
              'cost' => number_format($record->ride_cost, 2),
              'ride_status' => (isset($rideStatus[$record->status]) ? $rideStatus[$record->status] : ''),
              'payment_type' => ucfirst($record->payment_type),
              'company_name' => (!empty($record->company->name) ? $record->company->name : ''),
              'week' => date("W",strtotime($record->ride_time)),
              'note' => ucfirst($record->note),
           );
        }

        return collect($result);
    }
	
	public function headings(): array
    {
		return [
			'#',
			'Date',
			'Driver',
			'Vehicle',
			'Guest',
			'Pickup Address',
			'Destination Address',
			'Distance',
			'Ride Cost',
			'Status',
			'Payment Type',
			'Company',
			'Week',
			'Note',
		];
    }
}
