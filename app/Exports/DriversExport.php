<?php

namespace App\Exports;

use App\Ride;
use App\Salary;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DriversExport implements FromCollection, WithHeadings
{
    protected $req_params;

    public function __construct($req_params = array())
    {
        $this->req_params = $req_params;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if (Auth::user()->user_type == 3) {
            $sp_id = Auth::user()->id;
        } else {
            $sp_id = Auth::user()->service_provider_id;
        }
        $req_params = $this->req_params;
        $records = new User;

        if (!empty($req_params['search'])) {
            $records = $records->where(function ($query) use ($req_params) {
                $query->where(DB::raw('CONCAT_WS(" ", first_name, last_name)'), 'like', '%' . $req_params['search'] . '%');
                $query->orWhere(DB::raw('CONCAT_WS(" ", country_code, phone)'), 'like', '%' . $req_params['search'] . '%');
                $query->orWhere('email', 'like', '%' . $req_params['search'] . '%');
            });
        }
        if ($req_params['regular_master_filter'] == 'regular') {
            $records = $records->where(['is_master' => 0]);
        } else if ($req_params['regular_master_filter'] == 'master') {
            $records = $records->where(['is_master' => 1]);
        }
        $records = $records->where(['user_type' => 2, 'service_provider_id' => $sp_id])->orderBy('id', 'desc')->get();

        $result = array();
        foreach ($records as $record) {
            $salary = Salary::where(['driver_id' => $record->id, 'service_provider_id' => $sp_id])->first();
            $result[] = array(
                'first_name' => $record->first_name,
                'last_name' => $record->last_name,
                'phone' => (!empty($record->country_code)) ? '+' . $record->country_code . ' ' . $record->phone : '',
                'email' => $record->email,
                'master' => $record->is_master ? 'Yes' : 'No',
                'active' => $record->is_active ? 'Yes' : 'No',
                'salary_type' => $salary ? Str::ucfirst($salary->type) : '',
                'salary_rate' => $salary ? $salary->rate : '',
            );
        }

        return collect($result);
    }

    public function headings(): array
    {
        return [
            'Name',
            'Surname',
            'Phone Number',
            'Email Address',
            'Master',
            'Active',
            'Salary Type',
            'Percentage/Hourly Rate',
        ];
    }
}
