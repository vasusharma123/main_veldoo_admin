<?php

namespace App\Exports;

use App\Ride;
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

class RideExport implements FromCollection, WithHeadings, WithTitle, WithMapping, ShouldAutoSize
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
		if (!empty($this->data['from_date']) && !empty($this->data['to_date'])) {
			return Ride::where('created_at', '>=', $this->data['from_date'])->where('created_at', '<=', $this->data['to_date'])->orderBy('id', 'desc')->get();
		} elseif (!empty($this->data['id'])) {
			$user = \App\User::where('id', $this->data['id'])->first();
			if ($user->user_type == 1) {
				return Ride::where('user_id', $this->data['id'])->orderBy('id', 'desc')->get();
			} elseif ($user->user_type == 2) {
				return Ride::where('driver_id', $this->data['id'])->orderBy('id', 'desc')->get();
			}
		} else {
			return Ride::with(['driver', 'user', 'vehicle'])->orderBy('id', 'desc')->get();
		}
	}

	public function map($ride): array
	{
		return [
			$ride->id,
			date('d M, Y H:i:s', strtotime($ride->ride_time)),
			$ride->driver ? $ride->driver->first_name . ' ' . $ride->driver->last_name : '',
			$ride->vehicle->vehicle_number_plate ?? "",
			$ride->user ? $ride->user->first_name . ' ' . $ride->user->first_name : '',
			$ride->pickup_address,
			$ride->dest_address,
			$ride->distance,
			number_format($ride->ride_cost, 2),
			$this->ride_status[$ride->status] ?? "",
			ucfirst($ride->payment_type),
			$ride->company->name ?? "",
			date("W",strtotime($ride->ride_time)),
			ucfirst($ride->note)
		];
	}

	public function headings(): array
	{
		return [
			[
				trans('admin.ID'),
				"Date",
				trans('admin.Driver Name'),
				"Vehicle",
				"Guest",
				trans('admin.Pickup Address'),
				trans('admin.Destination Address'),
				"Distance",
				"Ride Cost",
				"Status",
				trans('admin.Payment Type'),
				"Company",
				"Week",
				"Note"
			],
		];
	}

	public function title(): string
	{
		return 'Rides List Veldoo';
	}
}
