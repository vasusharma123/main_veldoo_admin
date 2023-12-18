<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\SMSTemplate;
use Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Auth;

class SMSTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	 
	public function __construct(){
		
		$this->limit = 20;
    }
	 
    public function index(Request $request)
    {
		$data = array();
		$data = array('title' => 'List', 'action' => 'SMS Templates');
		
		$records = DB::table('sms_templates');
		
		$user_id = Auth::user()->id;
		
		if(!empty($request->input('text'))){
			$text = $request->input('text');
			$records->whereRaw("title LIKE '%$text%' AND service_provider_id=$user_id");
		}
		
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$records->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$records->orderBy('id', 'desc');
		}
		
		$data['records'] = $records->where(['service_provider_id'=>$user_id])->paginate($this->limit);
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] = $request->input('orderby');
		$data['order'] = $request->input('order');
        if ($request->ajax()) {
            return view("admin.sms-templates.index_element")->with($data);
        }
		
		return view('admin.sms-templates.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'SMS Templates';
        $data['action'] = 'SMS Templates';
	    return view('admin.sms-templates.create')->with($data);
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
            'title' => 'required',
            'english_content' => 'required',
            'german_content' => 'required',
        ]);

        $input = $request->except(['_method', '_token', 'submit']);
        
		try 
        {
            $input['service_provider_id'] = Auth::user()->id;
			
			$isuser = SMSTemplate::create($input);
			
            return redirect()->route('sms-template.index')->with('success', 'Template created!');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['title'] = 'SMS Templates';
        $data['action'] = 'SMS Templates';
        $data['template'] = SMSTemplate::where('service_provider_id',Auth::user()->id)->find($id);
	    return view('admin.sms-templates.edit')->with($data);
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
            'title' => 'required',
            'english_content' => 'required',
            'german_content' => 'required',
        ]);

        $input = $request->except(['_method', '_token', 'submit']);
        try 
        {
            $sms = SMSTemplate::where(['service_provider_id' => Auth::user()->id, 'id' => $id])->find($id);
			
			$sms->update($input);
			
            return redirect()->route('sms-template.index')->with('success', 'Template updated!');
        } catch (\Illuminate\Database\QueryException $exception) {
            DB::rollBack();
            return back()->with('error', $exception->getMessage());
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // $price = User::where('id',$request->user_id)->delete();
        // // $price->delete();

        
        // echo json_encode(true);
        // exit();
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
        $data = array('title' => 'Settings', 'action' => 'Company Information');
		return view("company.settings.index")->with($data);
    }
}
