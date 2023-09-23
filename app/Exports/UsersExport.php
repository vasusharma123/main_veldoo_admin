<?php

namespace App\Exports;

use App\User;
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

class UsersExport implements FromCollection,WithHeadings,WithTitle,WithMapping,ShouldAutoSize
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
		if(($this->data['type']=="rider")){
			return User::where('user_type',1)->orderBy('id','desc')->get();
		}elseif($this->data['type']=="driver"){
			return User::where('user_type',2)->orderBy('id','desc')->get();
		}elseif($this->data['type']=="company"){
			return User::where('user_type',4)->orderBy('id','desc')->get();
		}else{
			return User::where('user_type',1)->orderBy('id','desc')->get();
		}
    }
	
	
		public function map($user) : array {
			
		if($user->status==0){
			$status='Deactivated';
		}elseif($user->status==1){
			$status='Activated';
		}
			return [
			$user->id.' ',
			$user->first_name.' '.$user->last_name.' ',
			$user->phone.' ',
			$user->email.' ',
			$status,
			Carbon::parse($user->created_at)->toFormattedDateString()
		];
	}
	
		public function headings(): array
    {
        return [
           [trans('admin.ID'),trans('admin.Name'),trans('admin.Phone'),trans('admin.Email'),trans('admin.Status'),trans('admin.Created at')
		   ],
        ];
    }
	
	 public function title(): string
    {
    	return 'Users';
    }
}
