<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuestRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->isMethod('post')) {
            $inputs = \Request::all();
            if($inputs['first_name'] || $inputs['last_name']) {
                $rules = [
                    // 'email' => 'required|email|unique:users',
                     'password' => 'min:6|required_with:confirm_password|same:confirm_password',
                     'confirm_password' => 'required|min:6',
                     'phone'=>'unique:users|required',
                     'country_code'=>'required',
                 ];
            } else if (empty($inputs['first_name']) &&  empty($inputs['last_name'])) {
                $rules = [
                    // 'email' => 'required|email|unique:users',
                     'password' => 'min:6|required_with:confirm_password|same:confirm_password',
                     'confirm_password' => 'required|min:6',
                     'phone'=>'unique:users|required',
                     'country_code'=>'required',
                     'first_name'=>'required',
                     'last_name'=>'required',
                 ];
            }  
           
            return $rules;

        }
        return [];
    }
}
