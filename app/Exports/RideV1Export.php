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

class RideV1Export implements FromCollection, WithHeadings, WithTitle, WithMapping, ShouldAutoSize
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
		// dd($request);
		$rides = Ride::select(['rides.id', 'rides.user_id', 'rides.pickup_address', 'rides.dest_address', 'rides.ride_time', 'rides.distance', 'rides.status', 'rides.note', 'rides.ride_cost', 'rides.payment_type', 'users.first_name', 'users.last_name','guest.first_name as guest_first_name', 'guest.last_name as guest_last_name', 'vehicles.vehicle_number_plate', 'prices.seating_capacity', 'payment_methods.name AS payment_name','companies.name as company_name'])
                ->leftJoin('users', 'users.id', 'rides.driver_id')
                ->leftJoin('companies', 'companies.id', 'rides.company_id')
                ->leftJoin('users as guest', 'guest.id', 'rides.user_id')
                ->leftJoin('vehicles', 'vehicles.id', 'rides.vehicle_id')
                ->leftJoin('prices', function ($join) {
                    $join->on('vehicles.category_id', '=', 'prices.id')->where('prices.deleted_at', null);
                })
                ->leftJoin('payment_methods', 'payment_methods.id', 'rides.payment_type')
                ->orderBy('rides.id', 'DESC');
        if (isset($request['search']) && !empty($request['search'])) {
            $rides->where(function($query) use ($request){
                $query->orWhere('rides.id','LIKE','%'.$request['search'].'%');
                // $query->orWhere('users.first_name','LIKE','%'.$request['search'].'%');
                // $query->orWhere('users.last_name','LIKE','%'.$request['search'].'%');
                $query->orWhereRaw("CONCAT(`users`.`first_name`,' ',`users`.`last_name`) LIKE '%".$request['search']."%'");
                $query->orWhereRaw("CONCAT(`guest`.`first_name`,' ',`guest`.`last_name`) LIKE '%".$request['search']."%'");
                // $query->orWhere('guest.last_name','LIKE','%'.$request['search'].'%');
                $query->orWhere('vehicles.vehicle_number_plate','LIKE','%'.$request['search'].'%');
                $query->orWhere('rides.pickup_address','LIKE','%'.$request['search'].'%');
                $query->orWhere('rides.dest_address','LIKE','%'.$request['search'].'%');
                $query->orWhere('payment_type','LIKE','%'.$request['search'].'%');
            });
        }
        if ((isset($request['startDate']) && !empty($request['startDate'])) && (isset($request['endDate']) && !empty($request['endDate']))) {
            $startDate = Carbon::createFromFormat('d/m/Y', $request['startDate']);
            $endDate = Carbon::createFromFormat('d/m/Y', $request['endDate']);
            $rides->whereRaw('date(ride_time) between date("'.$startDate.'") and date("'.$endDate.'")');
        }
        $rides = $rides->with(['driver', 'user', 'vehicle'])->get();
		return $rides;
		
	}

	public function map($ride): array
	{
		// dd($ride);
		return [
			$ride->id,
			date('d M, Y H:i:s', strtotime($ride->ride_time)),
			$ride->first_name . ' ' . $ride->last_name,
			$ride->vehicle_number_plate,
			$ride->guest_first_name . ' ' . $ride->guest_last_name,
			$ride->pickup_address,
			$ride->dest_address,
			$ride->distance,
			number_format($ride->ride_cost, 2),
			$this->ride_status[$ride->status] ?? "",
			ucfirst($ride->payment_type),
			$ride->company_name,
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
