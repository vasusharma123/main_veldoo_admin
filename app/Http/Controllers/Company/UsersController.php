<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ride;
use App\RideHistory;
use DataTables;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Exports\RideExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Auth;
use Hash;
use Storage;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = array('page_title' => 'Users', 'action' => 'Users');
        $user = Auth::user();
        $company_id = $user->id;
        if ($user->user_type==5) 
        {
            $company_id = $user->company_id; 
        }
        $data['users'] = User::where(['user_type'=>1,'company_id'=>$company_id])->get();
        return view('company.company-users.index')->with($data);
    }

    public function create(Request $request)
	{
		$data = array('title' => 'Create User', 'action' => 'Create User');
		return view("company.company-users.create")->with($data);
	}

    public function checkUserInfoBtn(Request $request)
    {
        $request->validate([
            'country_code' => 'required',
            'phone' => 'required',
        ]);
        DB::beginTransaction();
        try 
        {
            $data['country_code'] = $request->country_code;
            $data['phone'] = $request->phone;
            $data['user_type'] = 1;

            $user = Auth::user();
            $company_id = $user->id;
            if ($user->user_type==5) 
            {
                $company_id = $user->company_id; 
            }

            $user = User::where($data)->first();
            if ($user) 
            {
                $user->fill(['company_id'=>$company_id]);
                $user->update();
                $request->session()->flash('status', 'User successfully created!');
                DB::commit();
                return response()->json(['status'=>1]);
            }
            DB::commit();
            return response()->json(['status'=>2]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status'=>0]);
        }
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'email|required|unique:users',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            // 'country' => 'required',
            // 'state' => 'required',
            // 'city' => 'required',
            // 'street' => 'required',
            // 'zip_code' => 'required',
            'image_tmp' => 'image|mimes:jpeg,png,jpg|max:2048',
            // 'password' => 'required',
        ]);
        DB::beginTransaction();
        try 
        {
            $data = collect($request->all())->forget(['_token','image_tmp','password','second_phone_number','second_country_code'])->toArray();
            $data['user_type'] = 1;
            $user = Auth::user();
            $company_id = $user->id;
            if ($user->user_type==5) 
            {
                $company_id = $user->company_id; 
            }
            $data['company_id'] = $company_id;
            $data['created_by'] = Auth::user()->id;
            if ($request->password) 
            {
                $data['password'] = Hash::make($request->password);
            }
            if ($request->second_phone_number) 
            {
                $data['second_phone_number'] = $request->second_phone_number;
                $data['second_country_code'] = $request->second_country_code;
            }

            $user = new User();
            $user->fill($data);
            $user->save();

            if($request->hasFile('image_tmp') && $request->file('image_tmp')->isValid())
            {
                $imageName = 'profile-image'.time().'.'.$request->image_tmp->extension();
                $image = Storage::disk('public')->putFileAs(
                    'user/'.$user->id, $request->image_tmp, $imageName
                );
                $user = User::find($user->id);
                $user->fill(['image'=>$image]);
                $user->update();
            }
            DB::commit();
            return redirect()->route('company-users.index')->with('success','User successfully created');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            User::where(['user_type'=>1,'company_id'=>Auth::user()->company_id,'id'=>$id])->delete();
            DB::commit();
            return redirect()->route('company-users.index')->with('success','User has been deleted');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    public function edit(Request $request,$id)
	{
		$data = array('title' => 'Edit User', 'action' => 'Edit User');
		$data['user'] = User::where(['user_type'=>1,'company_id'=>Auth::user()->company_id])->find($id);
		return view("company.company-users.edit")->with($data);
	}

    public function update(Request $request,$id)
    {
        $request->validate([
            'email' => 'email|required|unique:users,email,'.$id,
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            // 'country' => 'required',
            // 'state' => 'required',
            // 'city' => 'required',
            // 'street' => 'required',
            // 'zip_code' => 'required',
            'image_tmp' => 'image|mimes:jpeg,png,jpg|max:2048',
            // 'password' => 'required',
        ]);
        DB::beginTransaction();
        try 
        {
            $data = collect($request->all())->forget(['_token','image_tmp','password','second_phone_number','second_country_code'])->toArray();
            // $data['user_type'] = 1;
            // $data['company_id'] = Auth::user()->company_id;
            if ($request->password) 
            {
                $data['password'] = Hash::make($request->password);
            }
            if ($request->second_phone_number) 
            {
                $data['second_phone_number'] = $request->second_phone_number;
                $data['second_country_code'] = $request->second_country_code;
            }
            if($request->hasFile('image_tmp') && $request->file('image_tmp')->isValid())
            {
                $imageName = 'profile-image'.time().'.'.$request->image_tmp->extension();
                $data['image'] = Storage::disk('public')->putFileAs(
                    'user/'.$user->id, $request->image_tmp, $imageName
                );
            }
            $user = User::where(['user_type'=>1,'company_id'=>Auth::user()->company_id,'id'=>$id])->first();
            $user->fill($data);
            $user->update();

            DB::commit();
            return redirect()->route('company-users.index')->with('success','User successfully updated');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
