<?php

namespace App\Http\Controllers;
use Config;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Complaint;
use Mail;
class ContactSupportController extends Controller
{
	public function __construct() {
		$this->table = 'contacts';
		$this->folder = 'contact_support';
		view()->share('route', 'contact-support');
		$this->limit = Config::get('limit');
   }
    public function index(Request $request)
    {
	 $breadcrumb = array('title'=>'Complaints','action'=>'List Complaints');
		$data = [];
		$records =Complaint::select('complaints.*','users.first_name','users.last_name','categories.name','complain_types.title')->join('users','users.id','=','complaints.user_id')->join('categories','complaints.ride_type','=','categories.id')->join('complain_types','complaints.complain_type','=','complain_types.id');
		if($request->has('status') && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			DB::table($this->table)->where([['id', $request->input('id')]])->limit(1)->update(array('status' => $status));
		}
		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){
			\App\Topic::find($request->input('id'))->delete();
		}
		if(!empty($request->input('text'))){
			$records->where('first_name', 'like', '%'.$request->input('text').'%')->orWhere('categories.name', 'like', '%'.$request->input('text').'%')->orWhere('complain_types.title', 'like', '%'.$request->input('text').'%')->orWhere('message', 'like', '%'.$request->input('text').'%');
		}
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$records->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$records->orderBy('id', 'desc');
		}
		
		$data['array'] = $records->paginate($this->limit);
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] =$request->input('orderby');
		$data['order'] = $request->input('order');
		$data = array_merge($breadcrumb,$data);
        if ($request->ajax()) {
            return view("admin.{$this->folder}.index_element")->with($data);
        }
	    return view("admin.{$this->folder}.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
	    $breadcrumb = array('title'=>'Contact Support','action'=>'Contact To User OR Driver');
		
		$data = [];
		$data['users']=\App\User::where('user_type',1)->get();
		$data['drivers']=\App\User::where('user_type',2)->get();
		$data = array_merge($breadcrumb,$data);
		if ($request->ajax()) {
			return rand();
		}
	    return view("admin.{$this->folder}.create")->with($data);
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
			'message' => 'required',
		];
		$request->validate($rules);
		$data = array('text' => $request->message);
		if(!empty($request->user) && $request->user==1){
			$users=\App\User::whereIn('user_type',['1','2']);
		 }elseif(!empty($request->user) && $request->user==2){
				$users=\App\User::where('user_type',2);
		 }elseif(!empty($request->user) && $request->user==3){
			  $users=\App\User::where('user_type',1);
		 }
		  $users=$users->get();
		 foreach($users as $email){
					$res=Mail::send('admin.contact_support.contact_email', $data, function($message) use ($email) {
					$message->to($email->email)->subject('Contact Support');
					if(!empty($request->from)){
						$message->from($request->from,'Haylup Admin');
					}
				});
				 $insertDataArr=[
					'user_id'=>$email->id,
					'email'=>$email->email,
					'message'=>$request->message
					];
				\App\Contact::create($insertDataArr);
				}
		return back()->with('success', __('Message Sent Successfully!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
	    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, Posts $posts)
    public function update(Request $request, $id)
    {
		
		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Posts $posts)
    {
        //
    }
	
	public function replyToUser(Request $request){
		$rules = [
			'message' => 'required',
		];
		$request->validate($rules);
		$user=\App\User::where('id',$request->user_id)->first();
		$data = array('text' => $request->message);
		$email=Mail::send('admin.contact_support.complaint_reply_email', $data, function($message) use ($user) {
					$message->to($user->email)->subject('Complaint');
						return true;
				});
		return response()->json(['success'=>'Message Sent Successfully!']);
	}

}
