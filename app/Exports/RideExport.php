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

class RideExport implements FromCollection,WithHeadings,WithTitle,WithMapping,ShouldAutoSize
{
	protected  $data;
	
	function __construct($data) {
        $this->data = $data;
	}
	
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
		if(!empty($this->data['from_date']) && !empty($this->data['to_date'])){
			return Ride::where('created_at','>=',$this->data['from_date'])->where('created_at','<=',$this->data['to_date'])->orderBy('id','desc')->get();
		}elseif(!empty($this->data['id'])){
			$user=\App\User::where('id',$this->data['id'])->first();
			if($user->user_type==1){
				return Ride::where('user_id',$this->data['id'])->orderBy('id','desc')->get();
			}elseif($user->user_type==2){
				return Ride::where('driver_id',$this->data['id'])->orderBy('id','desc')->get();
			}
		}else{
			return Ride::orderBy('id','desc')->get();
		}
    }
	
		public function map($ride) : array {
			return [
			$ride->id.' ',
			$ride->user?$ride->user->first_name.' ':'NULL',
			$ride->driver?$ride->driver->first_name.' ':'NULL',
			$ride->pickup_address.' ',
			$ride->dest_address.' ',
			$ride->price.' ',
			$ride->car_type.' ',
			$ride->payment_type.' ',
			Carbon::parse($ride->created_at)->toFormattedDateString()
		];
	}
	
	public function headings(): array
    {
        return [
           [trans('admin.ID'),trans('admin.User Name'),trans('admin.Driver Name'),trans('admin.Pickup Address'),trans('admin.Destination Address'),trans('admin.Price'),trans('admin.Cart Type'),trans('admin.Payment Type'),trans('admin.Created at')
		   ],
        ];
    }
	
	 public function title(): string
    {
    	return 'Users';
    }
}
