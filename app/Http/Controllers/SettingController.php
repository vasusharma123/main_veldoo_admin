<?php

namespace App\Http\Controllers;
use Config;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Complaint;
use Mail;
class SettingController extends Controller
{
	public function __construct() {
		$this->table = 'settings';
		$this->folder = 'settings';
		view()->share('route', 'social-media-setting');
		$this->limit = Config::get('limit');
   }
    public function index(Request $request)
    {
	 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
	    $breadcrumb = array('title'=>'Social Media Settings','action'=>'Social Media Settings');
		
		$data = [];
		$settings=\App\Setting::select('value')->first();
		$settingArray=json_decode($settings->value);
		$data['facebook_link']=$settingArray->facebook_link;
		$data['twitter_link']=$settingArray->twitter_link;
		$data['instagram_link']=$settingArray->instagram_link;
		//$data['setting']=json_decode($settings->value);
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
			'facebook_link' => 'required',
			'twitter_link' => 'required',
			'instagram_link' => 'required',
		];
		$request->validate($rules);
			$setting = \App\Setting::where(['key'=>'_configuration'])->first();
		if (empty($setting)) {
			$setting = new Setting;
		} else {
			$record = json_decode($setting->value);
		}
		
		$setting->key = '_configuration';
		$input = $request->all();
		foreach($input as $key=>$value){
			$setting["value->$key"] = $value;
		}
		$setting->save();
		return back()->with('success', __('Updated Successfully!'));
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
	
	public function paymentSetting(Request $request){
	  $breadcrumb = array('title'=>'Payment Settings','action'=>'Payment Settings');
		
		$data = [];
		$settings=\App\Setting::select('value')->first();
		$settingArray=json_decode($settings->value);
		/* $data['paypal_email']=$settingArray->paypal_email;
		$data['admin_commission']=$settingArray->admin_commission;
		$data['base_delivery_price']=$settingArray->base_delivery_price;
		$data['base_delivery_distance']=$settingArray->base_delivery_distance;
		$data['tax']=$settingArray->tax;
		$data['credit_card_fee']=$settingArray->credit_card_fee;
		$data['stripe_mode']=$settingArray->stripe_mode; */
		$data['stripe_test_secret_key']=$settingArray->stripe_test_secret_key;
		$data['stripe_test_publish_key']=$settingArray->stripe_test_publish_key;
		$data = array_merge($breadcrumb,$data);
		if ($request->ajax()) {
			return rand();
		}
	    return view("admin.{$this->folder}.payment_setting")->with($data);
	}
	
	public function paymentSettingStore(Request $request){
		$rules = [
			//'paypal_email' => 'required',
			//'twitter_link' => 'required',
			//'instagram_link' => 'required',
		];
		$request->validate($rules);
			$setting = \App\Setting::where(['key'=>'_configuration'])->first();
		if (empty($setting)) {
			$setting = new Setting;
		} else {
			$record = json_decode($setting->value);
		}
		
		$setting->key = '_configuration';
		$input = $request->all();
		foreach($input as $key=>$value){
			$setting["value->$key"] = $value;
		}
		$setting->save();
		return back()->with('success', __('Updated Successfully!'));
	}

}
