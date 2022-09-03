<?php

namespace App\Http\Controllers;
use Config;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DailyReportController extends Controller
{
	public function __construct() {
		//$this->table = 'categories';
		$this->folder = 'daily_report';
		view()->share('route', 'daily-report');
		$this->limit = Config::get('limit');
   }
    public function index(Request $request)
    {
	    $breadcrumb = array('title'=>'Daily Report','action'=>'Daily Report');
		$data = [];
		$data['daily_rides_count']=\App\Ride::whereDate('ride_time',Carbon::now()->format('Y-m-d'))->count();
		$data['driver_count']=\App\User::where('user_type',2)->whereDate('created_at',Carbon::now()->format('Y-m-d'))->count();
		$data['rider_count']=\App\User::where('user_type',1)->whereDate('created_at',Carbon::now()->format('Y-m-d'))->count();
		$data['company_registered']=0;
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] =$request->input('orderby');
		$data['order'] = $request->input('order');
		$data = array_merge($breadcrumb,$data);
       /* if ($request->ajax()) {
            return view("admin.{$this->folder}.index_element")->with($data);
        }*/
	    return view("admin.{$this->folder}.index")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
	  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		
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
}
