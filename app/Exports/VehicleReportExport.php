<?php

namespace App\Exports;

use App\Vehicle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithEvents;
use PHPExcel_Worksheet_PageSetup;
use DB;
use App\DriverChooseCar;
use App\Ride;

class VehicleReportExport implements FromCollection, WithHeadings, WithTitle, WithMapping, ShouldAutoSize
{
	protected $data;
	protected $ride_status = [0 => "Process", 1 => "Accepted By Driver", 2 => "Ride Start", 3 => "Completed", 4 => "Driver Reached To Customer", -2 => "Cancelled", -4 => "Pending"];

	function __construct($data)
	{
		$this->data = $data;
	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function collection()
	{
		$start_date = date('Y-m-d',strtotime($this->data['start_date']));
		$end_date = date("Y-m-d",strtotime($this->data['end_date']));
		$choosen_slots = DriverChooseCar::with(['vehicle:id,vehicle_number_plate,model,year','driver:id,first_name,last_name,phone',
		])
		->where(function($query)use($start_date,$end_date){
			$query->whereRaw("Date(created_at) >= ? && Date(created_at) <= ?",[$start_date,$end_date]);
		})->where(['car_id' => $this->data['vehicle_id']])->get();
		if(!empty($choosen_slots)){
			foreach($choosen_slots as $slot_value){
				$slot_value->rides = Ride::where(['driver_id' => $slot_value->user_id])
				->where('ride_time', '>=', $slot_value->created_at->toDateTimeString())
				->where('ride_time', '<=', $slot_value->updated_at->toDateTimeString())
				->get();
			}
		}
		return $choosen_slots;
	}

	public function map($choosen_slots): array
	{
		if(!empty($choosen_slots->rides) && count($choosen_slots->rides) > 0){
			foreach($choosen_slots->rides as $ride_value){
				return [
					$choosen_slots->vehicle->vehicle_number_plate,
					$choosen_slots->vehicle->model." - ".$choosen_slots->vehicle->year,
					date('d M, Y h:i a',strtotime($choosen_slots->created_at)),
					date('d M, Y h:i a',strtotime($choosen_slots->updated_at)),
					$choosen_slots->mileage,
					$choosen_slots->logout_mileage,
					(!empty($choosen_slots->driver->first_name))?$choosen_slots->driver->first_name." ".$choosen_slots->driver->last_name." (".$choosen_slots->driver->phone.")":"",
					date('d M, Y h:i a',strtotime($ride_value->ride_time)),
					$ride_value->pickup_address,
					$ride_value->price
				];
			}
		} else {
			return [
				$choosen_slots->vehicle->vehicle_number_plate,
				$choosen_slots->vehicle->model." - ".$choosen_slots->vehicle->year,
				date('d M, Y h:i a',strtotime($choosen_slots->created_at)),
				date('d M, Y h:i a',strtotime($choosen_slots->updated_at)),
				$choosen_slots->mileage,
				$choosen_slots->logout_mileage,
				(!empty($choosen_slots->driver->first_name))?$choosen_slots->driver->first_name." ".$choosen_slots->driver->last_name." (".$choosen_slots->driver->phone.")":"",
				"",
				"",
				""
			];
		}
	}

	public function headings(): array
	{
		return [
			[
				"Vehicle",
				"Vehicle Model - Year",
				"Vehicle Occupied Start Date",
				"Vehicle Occupied End Date",
				"Start Mileage",
				"End Mileage",
				"Driver",
				"Ride Time",
				"Pickup address",
				"Amount",
				// "Total Revenue",
			],
		];
	}

	public function title(): string
	{
		return 'Vehicle List Veldoo';
	}
}
