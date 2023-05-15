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
use Auth;

class VehicleMileageReportExport implements FromCollection, WithHeadings, WithTitle, WithMapping, ShouldAutoSize
{
	protected $data;

	function __construct($data)
	{
		$this->data = $data;
	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function collection()
	{
		$start_date = date('Y-m-d', strtotime($this->data['start_date']));
		$end_date = date("Y-m-d", strtotime($this->data['end_date']));
		$choosen_slots = DriverChooseCar::with([
			'vehicle:id,vehicle_number_plate,model,year', 'driver:id,first_name,last_name,phone',
		])
		->whereHas('vehicle',function($vehicle){
			$vehicle->where('service_provider_id',Auth::user()->id);
		})
		->where(function ($query) use ($start_date, $end_date) {
			$query->whereRaw("Date(created_at) >= ? && Date(created_at) <= ?", [$start_date, $end_date]);
		})->get();
		return $choosen_slots;
	}

	public function map($choosen_slots): array
	{
		$interval = date_diff(date_create($choosen_slots->created_at), date_create($choosen_slots->updated_at));
		$choosen_slots->logout_mileage = (!empty($choosen_slots->logout_mileage))?$choosen_slots->logout_mileage:0;
		return [
			$choosen_slots->vehicle->vehicle_number_plate,
			$choosen_slots->vehicle->model . " - " . $choosen_slots->vehicle->year,
			date('d M, Y h:i a', strtotime($choosen_slots->created_at)),
			date('d M, Y h:i a', strtotime($choosen_slots->updated_at)),
			$choosen_slots->mileage,
			$choosen_slots->logout_mileage,
			(!empty($choosen_slots->driver->first_name)) ? $choosen_slots->driver->first_name . " " . $choosen_slots->driver->last_name . " (" . $choosen_slots->driver->phone . ")" : "",
			(!empty($interval->format('%d')))?$interval->format('%d days %h hours %i minutes'):$interval->format('%h hours %i minutes'),
			($choosen_slots->logout_mileage - $choosen_slots->mileage)
		];
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
				"Total Time",
				"Total KM Driven"
			],
		];
	}

	public function title(): string
	{
		return 'Vehicle Mileage Report Veldoo';
	}
}
