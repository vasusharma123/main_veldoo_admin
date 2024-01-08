<?php

namespace App\Exports;

use App\Ride;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class RideExport implements FromCollection, WithHeadings
{
	
	public function __construct($req_params=array()) 
    {
        $this->from_date = $req_params['exp_start_date'];
        $this->to_date = $req_params['exp_end_date'];
        $this->req_params = $req_params;
    }
	
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
		$from_date = $this->from_date;
		$to_date = $this->to_date;
		
		$records = Ride::with(['driver', 'user', 'vehicle']);
        $records = $records->whereDate('ride_time', '>=', $from_date)->whereDate('ride_time', '<=', $to_date);
        if(!empty($this->req_params['selected_ride'])){
            $records = $records->whereIn('id',$this->req_params['selected_ride']);
        }
        $records = $records->orderBy('id', 'desc')->get();
		
		/* echo '<pre>';
		print_r($records->toArray());
		exit; */
		
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
