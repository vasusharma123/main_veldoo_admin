<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use DataTables;
use App\Company;
use Auth;
use App\Ride;
use App\Price;
use URL;
class CompanyController extends Controller
{

        public function __construct() {
        $this->table = 'users';
        $this->folder = 'company';
        view()->share('route', 'company');
        $this->limit = config('app.record_limit_web');
        $this->successCode = 200;
        $this->errorCode = 401;
        $this->warningCode = 500;
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {
        $data['title'] = "Company";
        $data['action'] = "List Companies";
        // if ($request->ajax()) {
            
        //     $data = User::select(['id', 'name', 'country','state','city','email', 'phone','status','name','country_code', 'user_type'])->where('user_type',4)->orderBy('id','DESC')->get();
            
        //     return Datatables::of($data)
        //                     ->addIndexColumn()
        //                     ->addColumn('action', function ($row) {
        //                         $btn = '<div class="btn-group dropright">
        //                     <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        //                         Action
        //                     </button>
        //                     <div class="dropdown-menu">
                              
        //                         <a class="dropdown-item" href="'.route('company.show',$row->id) .'">'.trans("admin.View").'</a>
        //                         <a class="dropdown-item" href="'. route('company.edit',$row->id).'">'. trans("admin.Edit").'</a>
        //                         <a class="dropdown-item delete_record" data-id="'. $row->id .'">'.trans("admin.Delete").'</a>
        //                     </div>
        //                 </div>';
                                
                                  
                                
        //                         return $btn;
                        
        //                     })
        //                     ->addColumn('status', function ($row) {
        //                         $status=($row->status === 1)?'checked':'';
        //                         $btn = '<div class="switch">
        //                     <label>
        //                         <input type="checkbox" class="change_status" data-status="'.$row->status.'" data-id="'.$row->id.'" '.$status.'><span class="lever" data-id="'.$row->id.'" ></span>
        //                     </label>
        //                 </div>';
                                
                                  
                                
        //                         return $btn;
                        
        //                     })->addColumn('name', function ($row) {
        //                         return ucfirst($row->name);
        //                     })->addColumn('email', function ($row) {
        //                         return ($row->email)?$row->email:'N/A';
        //                     })->addColumn('country', function ($row) {
        //                         return ucfirst($row->country);
        //                     })->addColumn('city', function ($row) {
        //                         return ucfirst($row->city);
        //                     })->addColumn('state', function ($row) {
        //                         return ucfirst($row->state);
        //                     })
        //                     ->addColumn('country_code_phone', function ($row) {
        //                         return $row->country_code.'-'.$row->phone;
        //                     })
                           
        //                     ->rawColumns(['action','status','name','email','country','city','state'])
        //                     ->make(true);
        // }
        $companies = Company::orderBy('created_at','desc');
        if ($request->has('search') && !empty($request->search)) {
            $companies->where(function($query) use ($request){
                $query->orWhere('name','LIKE','%'.$request->search.'%');
                $query->orWhere('email','LIKE','%'.$request->search.'%');
                $query->orWhere('phone','LIKE','%'.$request->search.'%');
                $query->orWhere('state','LIKE','%'.$request->search.'%');
                $query->orWhere('city','LIKE','%'.$request->search.'%');
                $query->orWhere('country','LIKE','%'.$request->search.'%');
            })->orWhereHas('user', function($user) use ($request) {
                $user->where(function($query) use ($request){
                    $query->orWhere('name','LIKE','%'.$request->search.'%');
                    $query->orWhere('email','LIKE','%'.$request->search.'%');
                });
            });
        }
        $data['users'] = User::where(['user_type' => 1, 'company_id' => Auth::user()->company_id])->orderBy('name')->get();

        $data['vehicle_types'] = Price::orderBy('sort')->get();

        $data['companies'] = $companies->paginate(100);
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

    public function store(Request $request)
    {
        $this->validate($request, [
            'company_logo' => 'image|mimes:jpeg,png,jpg|max:2048',
            // 'user_name' => 'required|regex:/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/u|unique:users',
            // 'first_name' => 'required',
            'company_name' => 'required',
            // 'admin_password' => 'min:6',
            // 'company_country' => 'min:3',
            //'state' => 'required|min:3',
            // 'company_city' => 'min:3',
            // 'company_zip' => 'min:3',
            'status' => 'required',
            // 'company_phone' => 'required',
        ]);
        if ($request->has('admin_email') && !empty($request->admin_email)) {
            $this->validate($request, [
                'admin_email' => 'email|unique:users,email,NULL,id,deleted_at,NULL',
            ]);
        }

        DB::beginTransaction();
        try {
            // dd($request->all());
            if (
                ($request->has('admin_email') && !empty($request->admin_email)) ||
                ($request->has('admin_name') && !empty($request->admin_name)) ||
                ($request->has('admin_phone') && !empty($request->admin_phone)) ||
                ($request->has('admin_password') && !empty($request->admin_password))
            ) 
            {
                $data = ['first_name'=>$request->admin_name,'name'=>$request->admin_name,'email'=>$request->admin_email,'phone'=>$request->admin_phone,'country_code'=>$request->admin_country_code,'user_type'=>4,'status'=>$request->status];
                if ($request->admin_password) 
                {
                    $data['password'] = Hash::make($request->admin_password);
                }
    
                $user = new User();
                $user->fill($data);
                $user->save();

                if($request->hasFile('admin_profile_picture') && $request->file('admin_profile_picture')->isValid())
                {
                    $imageName = 'profile-image'.time().'.'.$request->admin_profile_picture->extension();
                    $image = Storage::disk('public')->putFileAs(
                        'user/'.$user->id, $request->admin_profile_picture, $imageName
                    );
                    $user = User::find($user->id);
                    $user->fill(['image'=>$image]);
                    $user->update();
                }
            }

            $companyData = ['name'=>$request->company_name,'email'=>$request->company_email,'phone'=>$request->company_phone,'country_code'=>$request->company_country_code,'street'=>$request->company_street,'state'=>$request->company_state,'zip'=>$request->company_zip,'country'=>$request->company_country,'city'=>$request->company_city];  
            $company = new Company();
            $company->fill($companyData);
            $company->save();

            if($request->hasFile('company_logo') && $request->file('company_logo')->isValid())
            {
                $imageName = 'logo-'.time().'.'.$request->company_logo->extension();
                $image = Storage::disk('public')->putFileAs(
                    'company/'.$company->id, $request->company_logo, $imageName
                );
                $company = Company::find($company->id);
                $company->fill(['logo'=>$image]);
                $company->update();
            }

            if($request->hasFile('company_background_image') && $request->file('company_background_image')->isValid())
            {
                $imageName = 'background-image-'.time().'.'.$request->company_background_image->extension();
                $image = Storage::disk('public')->putFileAs(
                    'company/'.$company->id, $request->company_background_image, $imageName
                );
                $company = Company::find($company->id);
                $company->fill(['background_image'=>$image]);
                $company->update();
            }

            if (
                ($request->has('admin_email') && !empty($request->admin_email)) || 
                ($request->has('admin_name') && !empty($request->admin_name)) || 
                ($request->has('admin_phone') && !empty($request->admin_phone)) || 
                ($request->has('admin_password') && !empty($request->admin_password))
            ) 
            {
                $user = User::find($user->id);
                $user->fill(['company_id'=>$company->id]);
                $user->update();
            }
            DB::commit();
            return back()->with('success', 'Company created!');
        } catch (\Illuminate\Database\QueryException $exception) {
            DB::rollBack();
            return back()->withInput()->with('error', $exception->getMessage());
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        $breadcrumb = array('title'=>trans('admin.Company'),'action'=>trans('admin.Company Detail'));
		$data = [];
        $where = array('id' => $id);
        $record = Company::where($where)->first();
		if(empty($record)){
			return redirect()->route("{$this->folder}.index")->with('warning', trans('admin.Record not found!'));
		}

		if ($request->ajax()) {
			if($request->has('type') && $request->input('type')=='approve' && !empty($request->input('id')) ){
				$company = \App\User::where(['id'=>$id])->first();
			if(empty($company)){
					// return response()->json(['message'=>"can't approve until bargain not finished."], $this->warningCode);
			}
				$company->update(['verify'=>1]);
				return response()->json(['message'=>trans('admin.Approved Succesfuly')], $this->successCode);
			}
		}
		
		$data['status'] = array(1=>'Active',0=>'In-active');
		$data['record'] = $record;
		$data = array_merge($breadcrumb,$data);
	    return view("admin.{$this->folder}.show")->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $breadcrumb = array('title'=>'Company','action'=>'Edit Company');
		$data = [];
        $where = array('id' => $id);
        $record = Company::where($where)->first();
		if(empty($record)){
			return redirect()->route("{$this->folder}.index")->with('warning', 'Record not found!');
		}
				  
		$data['record'] = $record;
		$data = array_merge($breadcrumb,$data);
	    return view("admin.{$this->folder}.edit")->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            // 'company_logo' => 'image|mimes:jpeg,png,jpg|max:2048',
            // 'user_name' => 'required|regex:/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/u|unique:users',
            // 'first_name' => 'required',
            'company_name' => 'required',
            // 'admin_email' => 'email|unique:users,email,NULL,id,deleted_at,NULL,email,'.$id,
            // 'admin_password' => 'min:6',
            // 'company_country' => 'required|min:3',
            //'state' => 'required|min:3',
            // 'company_city' => 'required|min:3',
            // 'company_zip' => 'required|min:3',
            'status' => 'required',
            // 'company_phone' => 'required',
        ]);
        if ($request->has('admin_email') && !empty($request->admin_email)) {
            $checkMail = User::where('email',$request->admin_email)->whereNull('deleted_at')->where('company_id','!=',$id)->first();
            if ($checkMail) 
            {
                return back()->with('error', 'The Admin email has already been taken.');
            }
        }
        // dd($request->all());
        DB::beginTransaction();
        try {

            $data = ['first_name'=>$request->admin_name,'name'=>$request->admin_name,'email'=>$request->admin_email,'phone'=>$request->admin_phone,'country_code'=>$request->admin_country_code,'user_type'=>4,'status'=>$request->status];
            if ($request->has('reset_password') && !empty($request->admin_password)) 
            {
                $data['password'] = Hash::make($request->admin_password);
            }

            $user = User::where('company_id',$id)->first();
            if ($user) {
                $user->fill($data);
                $user->update();
            }
            else
            {
                if (
                    ($request->has('admin_email') && !empty($request->admin_email)) || 
                    ($request->has('admin_name') && !empty($request->admin_name)) || 
                    ($request->has('admin_phone') && !empty($request->admin_phone)) || 
                    ($request->has('admin_password') && !empty($request->admin_password))
                ) 
                {
                    $user = new User();
                    $user->fill($data);
                    $user->save();
                }
            }
            

            if($request->hasFile('admin_profile_picture') && $request->file('admin_profile_picture')->isValid())
            {
                $imageName = 'profile-image'.time().'.'.$request->admin_profile_picture->extension();
                $image = Storage::disk('public')->putFileAs(
                    'user/'.$user->id, $request->admin_profile_picture, $imageName
                );
                $user = User::find($user->id);
                $user->fill(['image'=>$image]);
                $user->update();
            }

            $companyData = ['name'=>$request->company_name,'email'=>$request->company_email,'phone'=>$request->company_phone,'country_code'=>$request->company_country_code,'street'=>$request->company_street,'state'=>$request->company_state,'zip'=>$request->company_zip,'country'=>$request->company_country,'city'=>$request->company_city]; 
            // dd($companyData); 
            $company = Company::find($id);
            $company->fill($companyData);
            $company->update();

            if($request->hasFile('company_logo') && $request->file('company_logo')->isValid())
            {
                $imageName = 'logo-'.time().'.'.$request->company_logo->extension();
                $image = Storage::disk('public')->putFileAs(
                    'company/'.$company->id, $request->company_logo, $imageName
                );
                $company = Company::find($company->id);
                $company->fill(['logo'=>$image]);
                $company->update();
            }

            if($request->hasFile('company_background_image') && $request->file('company_background_image')->isValid())
            {
                $imageName = 'background-image-'.time().'.'.$request->company_background_image->extension();
                $image = Storage::disk('public')->putFileAs(
                    'company/'.$company->id, $request->company_background_image, $imageName
                );
                $company = Company::find($company->id);
                $company->fill(['background_image'=>$image]);
                $company->update();
            }

            if ($user) {
                $user = User::find($user->id);
                $user->fill(['company_id'=>$company->id]);
                $user->update();
            }
            DB::commit();
            return back()->with('success', 'Company updated!');
        } catch (\Illuminate\Database\QueryException $exception) {
            DB::rollBack();
            return back()->with('error', $exception->getMessage());
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->with('error', $exception->getMessage());
        }


    //   $query = User::where(['id'=>$id,'user_type'=>4]);
	// 	$haveUser = $query->first();
	// 	$rules = [
    //      'email' => 'required|'.(!empty($haveUser->id) ? 'unique:users,email,'.$haveUser->id : ''),
    //         'image_tmp' => 'image|mimes:jpeg,png,jpg|max:2048',
    //     ];
	// 	if(!empty($request->reset_password)){
	// 		$rules['password'] = 'required|min:6';
	// 	}
	// 	$request->validate($rules);
	// 	$input = $request->all();
	// 	if(!empty($request->reset_password)){
    //         $input['password'] = Hash::make($request->password);
    //     }
	// 	unset($input['_method'],$input['_token'],$input['image_tmp'],$input['reset_password']);
		
	// 	$path = 'users/'.$haveUser->id.'/profile/';
	// 	$pathDB = 'public/users/'.$haveUser->id.'/profile/';
		
	// 	if($request->hasFile('image_tmp') && $request->file('image_tmp')->isValid()){
			
	// 		$imageName = 'profile-image'.time().'.'.$request->image_tmp->extension();
	// 		if(!empty($haveUser->image)){
	// 			Storage::disk('public')->delete($haveUser->image);
	// 		}
			
	// 		$input['image'] = Storage::disk('public')->putFileAs(
	// 			'user/'.$haveUser->id, $request->image_tmp, $imageName
	// 		);
	// 	}
    //     User::where('id', $id)->update($input);
		
	// 	return back()->with('success', __('Record updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try 
        {
            Company::where('id',$request->company_id)->delete();
            Ride::where('company_id',$request->company_id)->update(['company_id'=>null]);

            User::where(['company_id'=>$request->company_id,'user_type'=>1])->update(['company_id'=>null]);
            User::where(['company_id'=>$request->company_id])->whereIn('user_type',[4,5])->forcedelete();

            DB::commit();
            return response()->json(['status'=>1,'message'=>'Deleted']);
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return response()->json(['status'=>0,'message'=>'something went wrong! please try again.']);
        }
    }

    /**
     * Created By Anil Dogra
     * Created At 09-08-2022
     * @var $request object of request class
     * @var $user object of user class
     * @return object with registered user id
     * This function use to  create contacts subject
    */
    public function change_status(Request $request){
        // dd($request->user_id);
        // DB::table('users')->update(['status'=>0]);
        $status = ($request->status=="true")?1:0;
        // dd($status);
        $updateUser = User::where('id',$request->user_id)->update(['status'=>$status]);
       
        if ($updateUser) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
        exit;
    }
	
    public function settings(Request $request)
    {
        $data = array('page_title' => 'Settings', 'action' => 'Settings');
        $data['company'] = Company::find(Auth::user()->company_id); 
        $data['users'] = User::where(['user_type'=>1,'company_id'=>Auth::user()->company_id])->paginate(20);
        $data['vehicle_types'] = Price::orderBy('sort')->get();
		return view("company.settings.index")->with($data);
    }

    public function updateCompanyInformation(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            // 'email' => 'email',
            // 'phone' => 'required',
            // 'country_code' => 'required',
            // 'state' => 'required|min:3',
            'city' => 'required|min:3',
            'zip_code' => 'required|min:3',
            'country' => 'required',

        ]);
        DB::beginTransaction();
        try 
        {
            $data = ['name'=>$request->name,'email'=>$request->email,'phone'=>$request->phone,'country_code'=>$request->country_code,'street'=>$request->street,'state'=>$request->state,'zip'=>$request->zip_code,'country'=>$request->country,'city'=>$request->city];  
            $company = Company::find(Auth::user()->company_id);
            if ($company) 
            {
                $company->fill($data);
                $company->update();
            }  
            else
            {
                $company = new Company();
                $company->fill($data);
                $company->save();
            }

            if($request->hasFile('logo') && $request->file('logo')->isValid())
            {
                $imageName = 'logo-'.time().'.'.$request->logo->extension();
                $image = Storage::disk('public')->putFileAs(
                    'company/'.$company->id, $request->logo, $imageName
                );
                $company = Company::find($company->id);
                $company->fill(['logo'=>$image]);
                $company->update();
            }
            if($request->hasFile('background_image') && $request->file('background_image')->isValid())
            {
                $imageName = 'background-image-'.time().'.'.$request->background_image->extension();
                $image = Storage::disk('public')->putFileAs(
                    'company/'.$company->id, $request->background_image, $imageName
                );
                $company = Company::find($company->id);
                $company->fill(['background_image'=>$image]);
                $company->update();
            }

            User::where('id',Auth::user()->id)->update(['company_id'=>$company->id]);
            DB::commit();
            return back()->with('success', 'Information updated!');
        } catch (\Exception $exception) {
            // dd($exception);
            DB::rollBack();
            return back()->with('error', $exception->getMessage());
        }
    }


    public function updateCompanyThemeInformation(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            //'header_color' => 'required',
            // 'email' => 'email',
            // 'phone' => 'required',
            // 'country_code' => 'required',
            // 'state' => 'required|min:3',
            //'input_color' => 'required',
           // 'zip_code' => 'required|min:3',
            //'country' => 'required',

        ]);
        DB::beginTransaction();
        try 
        {
            $data = [];
            if(!empty($request->reset_theme_design) && $request->reset_theme_design == 'reset_theme_design'){
                $data = ['logo' => '', 'background_image' => '','header_color'=> '', 'header_font_family'=> '', 'header_font_color'=> '', 'header_font_size'=> '', 'input_color'=> '', 'input_font_family'=> '', 'input_font_color'=> '', 'input_font_size'=> ''];  
            } else {
                $data = ['header_color'=>$request->header_color,'header_font_family'=>$request->header_font_family,'header_font_color'=>$request->header_font_color,'header_font_size'=>$request->header_font_size,'input_color'=>$request->input_color,'input_font_family'=>$request->input_font_family,'input_font_color'=>$request->input_font_color,'input_font_size'=>$request->input_font_size];  
            }

            $company = Company::find(Auth::user()->company_id);
            if ($company) 
            {
                $company->fill($data);
                $company->update();
            }  
            else
            {
                $company = new Company();
                $company->fill($data);
                $company->save();
            }

            if($request->hasFile('logo') && $request->file('logo')->isValid())
            {
                $imageName = 'logo-'.time().'.'.$request->logo->extension();
                $image = Storage::disk('public')->putFileAs(
                    'company/'.$company->id, $request->logo, $imageName
                );
                $company = Company::find($company->id);
                $company->fill(['logo'=>$image]);
                $company->update();
            }
            if($request->hasFile('background_image') && $request->file('background_image')->isValid())
            {
                $imageName = 'background-image-'.time().'.'.$request->background_image->extension();
                $image = Storage::disk('public')->putFileAs(
                    'company/'.$company->id, $request->background_image, $imageName
                );
                $company = Company::find($company->id);
                $company->fill(['background_image'=>$image]);
                $company->update();
            }

            User::where('id',Auth::user()->id)->update(['company_id'=>$company->id]);
            DB::commit();
            if(!empty($request->reset_theme_design) && $request->reset_theme_design == 'reset_theme_design'){
                return response()->json(['status'=>1,'message'=>'Information reset!']);
            } else {
                $urlToRedirect = URL::to('company/settings#weekView/');
                return redirect($urlToRedirect)->with('success', 'Information updated!');
            }
        } catch (\Exception $exception) {
            // dd($exception);
            DB::rollBack();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function updatePersonalInformation(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email',
            'phone' => 'required',

        ]);
        DB::beginTransaction();
        try 
        {
             //dd($request->all());
            $user = User::find(Auth::user()->id);

            $data = ['name'=>$request->name,'first_name'=>$request->name,'email'=> !empty($user->email) ? $user->email : $request->email,'phone'=>$request->phone,'country_code'=>$request->country_code];
            if ($request->password) 
            {
                $data['password'] = Hash::make($request->password);
            }
            
            $user->fill($data);
            $user->update();

            if($request->hasFile('image') && $request->file('image')->isValid())
            {
                $imageName = 'profile-image'.time().'.'.$request->image->extension();
                $image = Storage::disk('public')->putFileAs(
                    'user/'.$user->id, $request->image, $imageName
                );
                $user = User::find($user->id);
                $user->fill(['image'=>$image]);
                $user->update();
            }

            DB::commit();
            return back()->with('success', 'Information updated!');
        } catch (\Exception $exception) {
            // dd($exception);
            DB::rollBack();
            return back()->with('error', $exception->getMessage());
        }
    }

}
