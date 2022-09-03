<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
        $breadcrumb = array('title'=>'Company','action'=>'List Companies');
        $data = [];


        if($request->has('status') && !empty($request->input('id')) ){
            $status = ($request->input('status')?0:1);
            DB::table('users')->where([['id', $request->input('id')],['user_type', 1]])->limit(1)->update(array('status' => $status));
        }
        if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){
            DB::table($this->table)->where([['id', $request->input('id')]])->delete();
        }
        $users = DB::table('users');
        $users->where('user_type', '=',4);
        if(!empty($request->input('text'))){
            $users->where('first_name', 'like', '%'.$request->input('text').'%')->orWhere('last_name', 'like', '%'.$request->input('text').'%');
        }
        if(!empty($request->input('orderby')) && !empty($request->input('order'))){
            $users->orderBy($request->input('orderby'), $request->input('order'));
        } else {
            $users->orderBy('id', 'desc');
        }
        
        $data['users'] = $users->paginate($this->limit);
        $data['i'] =(($request->input('page', 1) - 1) * $this->limit);
        $data['orderby'] =$request->input('orderby');
        $data['order'] = $request->input('order');
        $data = array_merge($breadcrumb,$data);
        if ($request->ajax()) {
            return view('admin.company.index_element')->with($data);
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
       $rules = [
			'image_tmp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
			//'user_name' => 'required|regex:/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/u|unique:users',
			'first_name' => 'required',
			'last_name' => 'required',
			'email' => 'required|email|unique:users',
			'password' => 'required|min:6',
			'status' => 'required',
		];
		$request->validate($rules);
			DB::beginTransaction();
	try {	
		$data=['name'=>$request->first_name.' '.$request->last_name,'email'=>$request->email,'password'=>$request->password];
		$request->request->add([ 'password' => Hash::make($request->input('password')),'user_type' => 4]);
		$user  = User::create($request->all());
		//SAVE IMAGE
		$path = 'users/'.$user->id.'/profile/';
		$imageName = 'profile-image.'.$request->image_tmp->extension();
		
           $user['image']=Storage::disk('public')->putFileAs(
				'user/'.$user->id, $request->image_tmp, $imageName);
        
		$user->save();
		
		$m = Mail::send('admin.company.email', $data, function($message) use ($request) {
					$message->to($request->email, 'Login Credential')->subject('Login Credential');
				});
		DB::commit();
		return back()->with('success', 'Company created!');
		} catch (\Illuminate\Database\QueryException $exception){
			DB::rollBack();
			return back()->with('error',$exception->getMessage());
		}catch(\Exception $exception){
			DB::rollBack();
			return back()->with('error',$exception->getMessage());
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
		
		unset($input['_method'],$input['_token'],$input['image_tmp']);
		
		$path = 'users/'.$haveUser->id.'/profile/';
		$pathDB = 'public/users/'.$haveUser->id.'/profile/';
		
		if($request->hasFile('image_tmp') && $request->file('image_tmp')->isValid()){
			
			$imageName = 'profile-image.'.$request->image_tmp->extension();
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
    public function destroy($id)
    {
        //
    }
	

}
