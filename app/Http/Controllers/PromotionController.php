<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Promotion;
use Illuminate\Support\Facades\URL;

class PromotionController extends Controller
{
	
	public function __construct() {
		$this->table = 'promotions';
		$this->folder = 'promotion';
		view()->share('route', 'promotion');
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
       $breadcrumb = array('title'=>'Promotions','action'=>'List Promotions');
		$data = [];
		
		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){
			DB::table($this->table)->where([['id', $request->input('id')]])->delete();
		}
		$vouchers =\App\Promotion::query();
		if(!empty($request->input('text'))){
			$vouchers->where('promotion', 'like', '%'.$request->input('text').'%')
			->orWhere('type', 'like', '%'.$request->input('text').'%')
			->orWhere('start_date', 'like', '%'.$request->input('text').'%')
			->orWhere('end_date', 'like', '%'.$request->input('text').'%');
		}
		if(!empty($request->input('orderby')) && !empty($request->input('order'))){
			$vouchers->orderBy($request->input('orderby'), $request->input('order'));
		} else {
			$vouchers->orderBy('id', 'desc');
		}
		
		$data['promotion_offers'] = $vouchers->paginate($this->limit);
		$data['i'] =(($request->input('page', 1) - 1) * $this->limit);
		$data['orderby'] =$request->input('orderby');
		$data['order'] = $request->input('order');
		$data = array_merge($breadcrumb,$data);
        if ($request->ajax()) {
            return view('admin.promotion.index_element')->with($data);
        }
	    return view('admin.promotion.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $breadcrumb = array('title'=>'Promotion','action'=>'Add Promotion');
		
		$data = [];
		$data['users']=\App\User::where('user_type',1)->get();
		$data = array_merge($breadcrumb,$data);
	    return view('admin.promotion.create')->with($data);
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
			'title'=>'required',
			'description'=>'required',
			'type'=>'required',
			'start_date'=>'required',
			'end_date'=>'required',
		];
		
		$request->validate($rules);
		$promotion = new Promotion();
		$promotion->title = $request->title;
		$promotion->description = $request->description;
		$promotion->type = $request->type;
		$promotion->start_date = $request->start_date;
		$promotion->end_date = $request->end_date;
		if($request->type == 2)
		{
			$promotion->user_id = implode(",",$request->user_id);
		}
		if(!empty($_FILES['image'])){

                if(isset($_FILES['image']) && $_FILES['image']['name'] !== '' && !empty($_FILES['image']['name'])){
                    $file = $_FILES['image'];
                    $file = preg_replace("/[^a-zA-Z0-9.]/", "", $file['name']);
                    $filename = time().'-'.$file;
                    $ext = substr(strtolower(strrchr($file, '.')), 1); //get the extension
                    $arr_ext = array('jpg', 'jpeg', 'gif','png'); //set allowed extensions

                    if(in_array($ext, $arr_ext))
                    {
                    $path="public/images/user_image/";
                    if(move_uploaded_file($_FILES['image']['tmp_name'],$path.$filename)){
                       
						$url = URL::to('/');
                        $promotion->image = $url."/".$path.$filename;
                    }
                    }else{
                    
			return back()->with('error', 'upload Valid image');	
      
                     
                    }
				}
            }
		
		$promotion->save();
		return back()->with('success', 'Record created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        //
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
        //
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
