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
         $data = array();
        $data = array('title'=>'Company','action'=>'List Companies');
       

        if ($request->ajax()) {
            
            $data = User::select(['id', 'name', 'country','state','city','email', 'phone','status','name','country_code', 'user_type'])->where('user_type',4)->orderBy('id','DESC')->get();
            
            return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action', function ($row) {
                                $btn = '<div class="btn-group dropright">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu">
                              
                                <a class="dropdown-item" href="'.route('company.show',$row->id) .'">'.trans("admin.View").'</a>
                                <a class="dropdown-item" href="'. route('company.edit',$row->id).'">'. trans("admin.Edit").'</a>
                                <a class="dropdown-item delete_record" data-id="'. $row->id .'">'.trans("admin.Delete").'</a>
                            </div>
                        </div>';
                                
                                  
                                
                                return $btn;
                        
                            })
                            ->addColumn('status', function ($row) {
                                $status=($row->status === 1)?'checked':'';
                                $btn = '<div class="switch">
                            <label>
                                <input type="checkbox" class="change_status" data-status="'.$row->status.'" data-id="'.$row->id.'" '.$status.'><span class="lever" data-id="'.$row->id.'" ></span>
                            </label>
                        </div>';
                                
                                  
                                
                                return $btn;
                        
                            })->addColumn('name', function ($row) {
                                return ucfirst($row->name);
                            })->addColumn('email', function ($row) {
                                return ($row->email)?$row->email:'N/A';
                            })->addColumn('country', function ($row) {
                                return ucfirst($row->country);
                            })->addColumn('city', function ($row) {
                                return ucfirst($row->city);
                            })->addColumn('state', function ($row) {
                                return ucfirst($row->state);
                            })
                            ->addColumn('country_code_phone', function ($row) {
                                return $row->country_code.'-'.$row->phone;
                            })
                           
                            ->rawColumns(['action','status','name','email','country','city','state'])
                            ->make(true);
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
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            // 'user_name' => 'required|regex:/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/u|unique:users',
            // 'first_name' => 'required',
            'user_name' => 'required',
            'email' => 'email|unique:users,email,NULL,id,deleted_at,NULL',
            'password' => 'required|min:6',
            'country' => 'required|min:3',
            //'state' => 'required|min:3',
            'city' => 'required|min:3',
            'zip' => 'required|min:3',
            'status' => 'required',
            'phone' => 'required',

        ]);

        DB::beginTransaction();
        try {
            // dd($request->all());
            $data = array();
            $data['name'] = $request->user_name;
            $data['email'] = $request->email;
            $data['password'] = Hash::make($request->password);
            $data['user_type'] = 4;
            $data['country'] = $request->country;
            $data['state'] = $request->state;
            $data['city'] = $request->city;
            $data['street'] = $request->street;
            $data['zip'] = $request->zip;
            $data['status'] = $request->status;
            $data['addresses'] = $request->street;
            $data['country_code'] = $request->country_code;
            $data['phone'] = ltrim($request->phone, "0");
            $user = User::create($data);
            // dd($user);
            // Company
            $image = null;
            if (!empty($request->image)) {
                $imageName = 'profile-image' . time() . '.' . $request->image->extension();

                $image = Storage::disk('public')->putFileAs(
                    'user/' . $user->id,
                    $request->image,
                    $imageName
                );
            }

            $companyData = ['name'=>$request->user_name,'email'=>$request->email,'country_code'=>$request->country_code,'phone'=>$request->phone,'password'=>Hash::make($request->password),'image'=>$image,'country'=>$request->country,'state'=>$request->state,'city'=>$request->city,'street'=>$request->street,'zip'=>$request->zip];
            $company = new Company();
            $company->fill($companyData);
            $company->save();
            
            $user->company_id = $company->id;
            $user->image = $image;
            $user->save();

            if (!empty($request->email)) {
                // $m = Mail::send('admin.company.email', $data, function($message) use ($request) {
                //                   $message->to($request->email, 'Login Credential')->subject('Login Credential');
                // });
            }
            DB::commit();
            return back()->with('success', 'Company created!');
        } catch (\Illuminate\Database\QueryException $exception) {
            DB::rollBack();
            return back()->with('error', $exception->getMessage());
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->with('error', $exception->getMessage());
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
        $record = User::where($where)->first();
		
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
        $where = array('id' => $id,'user_type'=>4);
        $record = User::where($where)->first();
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
      $query = User::where(['id'=>$id,'user_type'=>4]);
		$haveUser = $query->first();
		$rules = [
         'email' => 'required|'.(!empty($haveUser->id) ? 'unique:users,email,'.$haveUser->id : ''),
            'image_tmp' => 'image|mimes:jpeg,png,jpg|max:2048',
        ];
		if(!empty($request->reset_password)){
			$rules['password'] = 'required|min:6';
		}
		$request->validate($rules);
		$input = $request->all();
		
		unset($input['_method'],$input['_token'],$input['image_tmp'],$input['reset_password']);
		
		$path = 'users/'.$haveUser->id.'/profile/';
		$pathDB = 'public/users/'.$haveUser->id.'/profile/';
		
		if($request->hasFile('image_tmp') && $request->file('image_tmp')->isValid()){
			
			$imageName = 'profile-image'.time().'.'.$request->image_tmp->extension();
			if(!empty($haveUser->image)){
				Storage::disk('public')->delete($haveUser->image);
			}
			
			$input['image'] = Storage::disk('public')->putFileAs(
				'user/'.$haveUser->id, $request->image_tmp, $imageName
			);
		}
		
		User::where('id', $id)->update($input);
		
		return back()->with('success', __('Record updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $price = User::where('id',$request->user_id)->delete();
        // $price->delete();

        
        echo json_encode(true);
        exit();
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
        DB::table('users')->update(['status'=>0]);
        $status = ($request->status)?0:1;
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
		return view("company.settings.index")->with($data);
    }

    public function updateCompanyInformation(Request $request)
    {
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
            // dd($request->all());
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
            // dd($request->all());
            $data = ['name'=>$request->name,'email'=>$request->email,'phone'=>$request->phone,'country_code'=>$request->country_code];
            if ($request->password) 
            {
                $data['password'] = Hash::make($request->password);
            }

            $user = User::find(Auth::user()->id);
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
