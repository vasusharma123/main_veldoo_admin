<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Company;
use App\Ride;
use App\ServiceProviderDriver;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{

    public function __construct()
    {
    }
	
	public function index(Request $request)
	{
		$this->limit = 20;
		
		$data = array();
		$data = array('title' => 'Companies', 'action' => 'List Companies');
		
		$records = DB::table('users');
		
		if($request->has('status') && $request->input('type')=='status' && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			DB::table('companies')->where([['id', $request->input('id')]])->limit(1)->update(array('status' => $status));
		}
		
		$records->selectRaw("id, name, email, company_id, IFNULL((SELECT name FROM companies WHERE id = users.company_id LIMIT 1), '') AS company_name, IFNULL((SELECT email FROM companies WHERE id = users.company_id LIMIT 1), '') AS company_email, IFNULL((SELECT country_code FROM companies WHERE id = users.company_id LIMIT 1), '') AS company_country_code, IFNULL((SELECT phone FROM companies WHERE id = users.company_id LIMIT 1), '') AS company_phone, IFNULL((SELECT state FROM companies WHERE id = users.company_id LIMIT 1), '') AS company_state, IFNULL((SELECT city FROM companies WHERE id = users.company_id LIMIT 1), '') AS company_city, IFNULL((SELECT country FROM companies WHERE id = users.company_id LIMIT 1), '') AS company_country, IFNULL((SELECT status FROM companies WHERE id = users.company_id LIMIT 1), '') AS company_status");
		
		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			
			#DB::table('users')->where([['id', $request->input('id')],['user_type', 4]])->limit(1)->update(array('deleted' => $status));
		}
		
		if(!empty($request->input('text'))){
			$text = $request->input('text');
			$records->whereRaw("(name LIKE '%$text%' OR email LIKE '%$text%' OR IFNULL((SELECT name FROM companies WHERE id = users.company_id LIMIT 1), '') LIKE '%$text%' OR IFNULL((SELECT email FROM companies WHERE id = users.company_id LIMIT 1), '') LIKE '%$text%' OR IFNULL((SELECT phone FROM companies WHERE id = users.company_id LIMIT 1), '') LIKE '%$text%' OR IFNULL((SELECT state FROM companies WHERE id = users.company_id LIMIT 1), '') LIKE '%$text%' OR IFNULL((SELECT city FROM companies WHERE id = users.company_id LIMIT 1), '') LIKE '%$text%' OR IFNULL((SELECT country FROM companies WHERE id = users.company_id LIMIT 1), '') LIKE '%$text%') AND user_type IN(4,5) AND deleted=0");
		}
		
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$records->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$records->orderBy('id', 'desc');
		}
		
		$data['records'] = $records->where(['deleted'=>0])->whereIn('user_type', [4,5])->paginate($this->limit);
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] =$request->input('orderby');
		$data['order'] = $request->input('order');
        if ($request->ajax()) {
            return view("admin.company.index_element")->with($data);
        }
		
		return view('admin.company.index')->with($data);
	}
	
	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	    $breadcrumb = array('title'=>'Company','action'=>'Add Company');

		$data = [];
		$data = array_merge($breadcrumb,$data);
	    return view('admin.company.create')->with($data);
    }
	
	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
		
		$rules = [
			'name' => 'required',
			'country_code' => 'required',
			'phone' => 'required',
			'email' => 'required|email',
			'street' => 'required',
			'zip' => 'required',
			'city' => 'required',
			'state' => 'required',
			'country' => 'required',
			'admin_name' => 'required',
			'admin_country_code' => 'required',
			'admin_phone' => 'required',
			'admin_email' => 'required|email',
			'password' => 'required|min:6',
			'confirm_password' => 'required|min:6|same:password',
		];
		
		$request->validate($rules);
		
		$input = $request->except(['_method', '_token']);
		
		try{
			
			$isUser = User::where(['email' => $request->email, 'user_type' => 4])->first();
			
			if(!empty($isUser)){
				return back()->withErrors(['message' => 'Email already exists']);
			}
			
			$admininput['service_provider_id'] = Auth::user()->id;
			$admininput['first_name'] = $input['admin_name'];
			$admininput['name'] = $input['admin_name'];
			$admininput['country_code'] = $input['admin_country_code'];
			$admininput['phone'] = $input['admin_phone'];
			$admininput['email'] = $input['admin_email'];
			$admininput['user_type'] = 4;
			$admininput['status'] = 1;
			$admininput['password'] = Hash::make($input['password']);
			
			$isuser = User::create($admininput);
			
			if(!empty($request->image_tmp)){
				$imgname = 'img-'.time().'.'.$request->image_tmp->extension();
				
				$isuser->image = Storage::disk('public')->putFileAs(
					'user/'.$isuser->id.'/', $request->image_tmp, $imgname
				);
				
				$isuser->save();
			}
			
			$companyinput['name'] = $input['name'];
			$companyinput['country_code'] = $input['country_code'];
			$companyinput['phone'] = $input['phone'];
			$companyinput['email'] = $input['email'];
			$companyinput['street'] = $input['street'];
			$companyinput['zip'] = $input['zip'];
			$companyinput['city'] = $input['city'];
			$companyinput['state'] = $input['state'];
			$companyinput['country'] = $input['country'];
			
			$iscompany = Company::create($companyinput);
			
			$isuser->company_id = $iscompany->id;
			$isuser->save();
			
			if(!empty($request->company_image_tmp)){
				$imgname = 'img-'.time().'.'.$request->company_image_tmp->extension();
				
				$iscompany->image = Storage::disk('public')->putFileAs(
					'company/'.$iscompany->id.'/', $request->company_image_tmp, $imgname
				);
				
				$iscompany->save();
			}
			
			if(!empty($request->background_image)){
				$imgname = 'back-img-'.time().'.'.$request->background_image->extension();
				
				$iscompany->background_image = Storage::disk('public')->putFileAs(
					'company/'.$iscompany->id.'/', $request->background_image, $imgname
				);
				
				$iscompany->save();
			}
			
			return back()->with('success', __('Created successfully!'));
		}catch (\Illuminate\Database\QueryException $exception){
			return back()->with('success', $exception->getMessage());
		} catch(\Exception $exception){
			return back()->with('success', $exception->getMessage());
		}
    }
	
	/**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
	    $breadcrumb = array('title'=>'Company','action'=>'Edit Company');
		$data = [];
        $where = array('id' => $id);
        $record = User::where($where)->with(['company'])->first();
		
		if(empty($record)){
			return redirect()->route("company.index")->with('warning', 'Record not found!');
		}
		
		$data['record'] = $record;
		
		$data = array_merge($breadcrumb,$data);
	    return view("admin.company.edit")->with($data);
    }
	
	/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, Posts $posts)
    public function update(Request $request, $id){
		
		$rules = [
			'name' => 'required',
			'country_code' => 'required',
			'phone' => 'required',
			'email' => 'required|email',
			'street' => 'required',
			'zip' => 'required',
			'city' => 'required',
			'state' => 'required',
			'country' => 'required',
			'admin_name' => 'required',
			'admin_country_code' => 'required',
			'admin_phone' => 'required',
			'admin_email' => 'required|email',
		];
		
		if(!empty($request->password)){
			$rules['password'] = 'required|min:6';
			$rules['confirm_password'] = 'required|min:6|same:password';
		}
		
		$request->validate($rules);
		$input = $request->except(['_method', '_token']);
		
		$input = $request->all();
		
		$isUserEmail = User::where(['email' => $input['admin_email'], 'user_type' => 4])->first();
		
		if(!empty($isUserEmail) && $isUserEmail->id != $id){
			return back()->withErrors(['message' => 'Email already exists']);
		}
		
		$udata = User::where('id', $id)->first();
		
		$admininput['first_name'] = $input['admin_name'];
		$admininput['name'] = $input['admin_name'];
		$admininput['country_code'] = $input['admin_country_code'];
		$admininput['phone'] = $input['admin_phone'];
		$admininput['email'] = $input['admin_email'];
		
		if(!empty($input['password'])){
			$admininput['password'] = Hash::make($input['password']);
		}
		
		if(!empty($request->image_tmp)){
			
			if(!empty($udata->image)){
				Storage::disk('public')->delete($udata->image);
			}
			
			$imgname = 'img-'.time().'.'.$request->image_tmp->extension();
			
			$admininput['image'] = Storage::disk('public')->putFileAs(
				'user/'.$udata->id.'/', $request->image_tmp, $imgname
			);
		}
		
		$udata->update($admininput);
		
		$cdata = Company::where('id', $udata->company_id)->first();
		if(!empty($cdata->id)){
			
			$companyinput['name'] = $input['name'];
			$companyinput['country_code'] = $input['country_code'];
			$companyinput['phone'] = $input['phone'];
			$companyinput['email'] = $input['email'];
			$companyinput['street'] = $input['street'];
			$companyinput['zip'] = $input['zip'];
			$companyinput['city'] = $input['city'];
			$companyinput['state'] = $input['state'];
			$companyinput['country'] = $input['country'];
			
			if(!empty($request->company_image_tmp)){
				
				if(!empty($cdata->image)){
					Storage::disk('public')->delete($cdata->image);
				}
				
				$imgname = 'img-'.time().'.'.$request->company_image_tmp->extension();
				
				$companyinput['image'] = Storage::disk('public')->putFileAs(
					'company/'.$cdata->id.'/', $request->company_image_tmp, $imgname
				);
			}
			
			if(!empty($request->background_image)){
				
				if(!empty($cdata->background_image)){
					Storage::disk('public')->delete($cdata->background_image);
				}
				
				$imgname = 'back-img-'.time().'.'.$request->background_image->extension();
				
				$companyinput['background_image'] = Storage::disk('public')->putFileAs(
					'company/'.$cdata->id.'/', $request->background_image, $imgname
				);
			}
			
			$cdata->update($companyinput);
		}
		
		return back()->with('success', trans('admin.Record updated!'));
    }
	
    public function destroy(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            // $currentTime = Carbon::now();
            // User::where('id', $request->user_id)->delete();
            // Ride::where(['driver_id' => $request->user_id])->where('ride_time', '>', $currentTime)->update(['driver_id' => null]);
            ServiceProviderDriver::where(['service_provider_id'=>Auth::user()->id,'driver_id'=>$request->user_id])->delete();
            DB::commit();
            return response()->json(['status' => 1, 'message' => __('The driver has been deleted.')]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
        }
    }

}
