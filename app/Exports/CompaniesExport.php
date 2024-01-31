<?php

namespace App\Exports;

use App\Company;
use App\Salary;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CompaniesExport implements FromCollection, WithHeadings
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
        $records = Company::with(['user']);

        if (!empty($req_params['search'])) {
            $text = $req_params['search'];
            $records = $records->where(function ($query) use ($text) {
                $query->where('name', 'like', '%' . $text . '%');
                $query->orWhereHas('user', function ($query1) use ($text) {
                    $query1->where(DB::raw('CONCAT_WS(" ", first_name, last_name)'), 'like', '%' . $text . '%');
                    $query1->orWhere(DB::raw('CONCAT_WS(" ", country_code, phone)'), 'like', '%' . $text . '%');
                    $query1->orWhere('email', 'like', '%' . $text . '%');
                });
            });
        }

        $records = $records->where(['service_provider_id' => $sp_id])->orderBy('id', 'desc')->get();

        $result = array();
        foreach ($records as $record) {
            $result[] = array(
                'name' => $record->name,
                'phone' => (!empty($record->country_code)) ? '+' . $record->country_code . ' ' . $record->phone : '',
                'email' => $record->email,
                'street' => $record->street,
                'zip' => $record->zip,
                'city' => $record->city,
                'state' => $record->state,
                'country' => $record->country,
                'status' => $record->status ? 'Active' : 'Inactive',
                'admin_name' => (!empty($record->user) ? $record->user->name : ''),
                'admin_phone' => (!empty($record->user->country_code)) ? '+' . $record->user->country_code . ' ' . $record->user->phone : '',
                'admin_email' => (!empty($record->user) ? $record->user->email : ''),
            );
        }

        return collect($result);
    }

    public function headings(): array
    {
        return [
            'Company Name',
            'Company Phone',
            'Company Email',
            'Street',
            'Post Code',
            'City',
            'State',
            'Country',
            'Status',
            'Admin Name',
            'Admn Phone',
            'Admin Email Address',
        ];
    }
}
