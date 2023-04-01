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
use Auth;

class VehicleExport implements FromCollection, WithHeadings, WithTitle, WithMapping, ShouldAutoSize
{
	protected  $data;
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
		return Vehicle::with(['last_driver_choosen.driver', 'carType'])->where('service_provider_id',Auth::user()->id)->orderBy('id', 'DESC')->get();
	}

	public function map($vehicle): array
	{
		return [
			$vehicle->id,
			$vehicle->vehicle_number_plate,
			(!empty($vehicle->last_driver_choosen->created_at) ? date('d M, Y h:i a', strtotime($vehicle->last_driver_choosen->created_at)) : ""),
			(!empty($vehicle->last_driver_choosen->updated_at) && !empty($vehicle->last_driver_choosen->logout) && $vehicle->last_driver_choosen->logout == 1) ? date('d M, Y h:i a', strtotime($vehicle->last_driver_choosen->updated_at)) : "",
			(!empty($vehicle->last_driver_choosen->mileage) ? $vehicle->last_driver_choosen->mileage : ""),
			(!empty($vehicle->last_driver_choosen->logout_mileage) && !empty($vehicle->last_driver_choosen->logout) && $vehicle->last_driver_choosen->logout == 1) ? $vehicle->last_driver_choosen->logout_mileage : "",
			(!empty($vehicle->last_driver_choosen->driver->first_name) ? $vehicle->last_driver_choosen->driver->first_name . "" . $vehicle->last_driver_choosen->driver->last_name : ""),
		];
	}

	public function headings(): array
	{
		return [
			[
				"ID",
				"Car",
				"Start Date",
				"End Date",
				"Start Mileage",
				"End Mileage",
				// "Total Revenue",
				"Driver"
			],
		];
	}

	public function title(): string
	{
		return 'Vehicle List Veldoo';
	}
}
