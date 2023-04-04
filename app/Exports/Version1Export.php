<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Carbon\Carbon;
use App\Ride;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithEvents;
use PHPExcel_Worksheet_PageSetup;
use DB;

class Version1Export implements FromCollection, WithHeadings, WithTitle, WithMapping, ShouldAutoSize
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
		$request = $this->data;
		$ride = Ride::orderBy('id', 'DESC');
        if (!empty($request['search'])) {
			$ride->where(function($query) use ($request){
                $query->orWhere('rides.id','LIKE','%'.$request['search'].'%');
                $query->orWhere('users.first_name','LIKE','%'.$request['search'].'%');
                $query->orWhere('users.last_name','LIKE','%'.$request['search'].'%');
                $query->orWhere('guest.first_name','LIKE','%'.$request['search'].'%');
                $query->orWhere('guest.last_name','LIKE','%'.$request['search'].'%');
                $query->orWhere('vehicles.vehicle_number_plate','LIKE','%'.$request['search'].'%');
                $query->orWhere('rides.pickup_address','LIKE','%'.$request['search'].'%');
                $query->orWhere('rides.dest_address','LIKE','%'.$request['search'].'%');
                $query->orWhere('payment_type','LIKE','%'.$request['search'].'%');
            });
        }
        $data['start_Date'] = "";
        $data['end_Date'] = "";
        if (!empty($request['startDate'] && $request['endDate'])) {
            $data['start_Date'] = $request['startDate'];
            $data['end_Date'] = $request['endDate'];
            $startDate = Carbon::createFromFormat('d/m/Y',$request['startDate']);
            $endDate = Carbon::createFromFormat('d/m/Y', $request['endDate']);

			$ride->whereRaw('date(ride_time) between date("'.$startDate.'") and date("'.$endDate.'")');
			
        }
		return $ride;
		
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
