<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ride;
use App\RideHistory;
use DataTables;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Exports\RideExport;
use App\PaymentMethod;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Hash;
use Storage;
use App\Price;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class ManagersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->user_type == 6){
            $user_type = 7;
        }else if(Auth::user()->user_type == 3){
            $user_type = 8;
        }
        
        //dd(\Request::route()->getName());
        $data = array('page_title' => 'Managers', 'action' => 'Managers','page' => 'manager','uri' => 'manager');
        $company = Auth::user();
        $data['managers'] = User::where(['user_type'=> $user_type ,'service_provider_id '=>Auth::user()->service_provider_id])->orderBy('first_name', 'ASC')->paginate(20);
       
        if(Auth::user()->user_type == 6){
            return view('managers.index')->with($data);
        }else if(Auth::user()->user_type == 3){
            return view('service_provider.index')->with($data);
        }
      
    }

    public function create(Request $request)
	{
		$breadcrumb = array('page_title' => 'Create Manager', 'action' => 'Create Manager');
		$data = [];
		$data = array_merge($breadcrumb, $data);
		return view("company.managers.create")->with($data);
	}

    public function store(Request $request)
    {
        Log::info('In manager store');
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:191'],
            'name' => 'required',
            'password' => 'required',
            'phone' => 'nullable|numeric',
        ]);
        DB::beginTransaction();
        try
        {
           if(User::where('email',$request->email)->where('user_type',$request->type)->exists()){
                return redirect()->route('master-manager.index')->with('error','Email already exist');
            }

            $data = ['service_provider_id' => Auth::user()->id, 'name'=>$request->name, 'first_name' => $request->name, 'email' => $request->email, 'password' => Hash::make($request->password), 'user_type' => $request->type, 'company_id' => Auth::user()->company_id];
            $data['created_by'] = Auth::user()->id;
            if ($request->phone)
            {
                $data['phone'] = str_replace(' ', '', $request->phone);
                $data['country_code'] = $request->country_code;
            }
            $manager = new User();
            $manager->fill($data);
            $manager->save();
            if($request->type == 7){
                $user_type = 'master-manager';
            }else{
                $user_type = 'service-provider-manager';
            }
            if ($request->image) {
                
                //dd($request->image);
				$imageName = 'profile-image'.time().'.' . $request->image->extension();
				$image = Storage::disk('public')->putFileAs(
					$user_type.'/' . $manager->id,
					$request->image,
					$imageName
				);
				User::where('id', $manager->id)->update(['image' => $image]);
			}
            DB::commit();

            return redirect()->route($user_type.'.index')->with('success','Manager successfully created');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    public function destroy(Request $request,$id)
    {
        DB::beginTransaction();
        try {
            User::where(['user_type'=>$request->type,'id'=>$id])->delete();
            DB::commit();
            if($request->type == 7){
                $user_type = 'master-manager';
            }else{
                $user_type = 'service-provider-manager';
            }
            return redirect()->route($user_type.'.index')->with('success','Manager has been deleted');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    public function edit(Request $request,$id)
	{
		$data = array('page_title' => 'Edit Manager', 'action' => 'Edit Manager');
		$data['manager'] = User::where(['user_type'=>5,'company_id'=>Auth::user()->company_id])->find($id);
		return view("company.managers.edit")->with($data);
	}


    public function updateStatus(Request $request)
	{
        User::where('id',Crypt::decrypt($request->id))->where('user_type',$request->type)->update(["status" => $request->status,'is_active' => $request->status]);
		
        return redirect()->route('master-manager.index')->with('success','Manager has been updated');
	}



    public function update(Request $request,$id)
    {
        //dd($request->all());
        $request->validate([
           // 'email' => 'email|required|unique:users,email,'.$id,
            'email' => ['required', 'string', 'email', 'max:191'],
            'name' => 'required',
            // 'password' => 'required',
        ]);


       

        DB::beginTransaction();
        try
        {

            $existEmail = User::where(['user_type'=>$request->type,'company_id'=>Auth::user()->company_id])->whereNull('deleted_at')
            ->where('id', '!=', $id)->where('email', $request->email)->first();

            if($existEmail){
                return redirect()->back()->with('error','The email has already been taken')->withInput($request->all());
            }

            $data = ['first_name'=>$request->name, 'name'=>$request->name,'email'=>$request->email];
            if ($request->phone)
            {
                $data['phone'] = str_replace(' ', '', $request->phone);
                $data['country_code'] = $request->country_code;
            }
            if ($request->password)
            {
                $data['password'] = Hash::make($request->password);
            }
            if($request->type == 7){
                $user_type = 'master-manager';
            }else{
                $user_type = 'service-provider-manager';
            }

            if ($request->image) {
				$imageName = 'profile-image'.time().'.' . $request->image->extension();
				$image = Storage::disk('public')->putFileAs(
					$user_type.'/' . $id,
					$request->image,
					$imageName
				);
				User::where('id', $id)->update(['image' => $image]);
			}
            // dd($data);
            $manager = User::where(['user_type'=>$request->type,'company_id'=>Auth::user()->company_id])->find($id);
            $manager->fill($data);
            $manager->update();
            DB::commit();
            

            return redirect()->route($user_type.'.index')->with('success','Manager information successfully updated.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    
}
