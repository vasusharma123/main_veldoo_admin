<?php

namespace App\Http\Controllers;
use Config;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CategoryController extends Controller
{
	public function __construct() {
		$this->table = 'categories';
		$this->folder = 'category';
		view()->share('route', 'category');
		$this->limit = Config::get('limit');
   }
    public function index(Request $request)
    {
	    $breadcrumb = array('title'=>'Category','action'=>'List Categories');
		$data = [];
		$records = DB::table($this->table);
		if($request->has('status') && !empty($request->input('id')) ){
			$status = ($request->input('status')?0:1);
			DB::table($this->table)->where([['id', $request->input('id')]])->limit(1)->update(array('status' => $status));
		}
		if($request->has('type') && $request->input('type')=='delete' && !empty($request->input('id')) ){
			\App\Topic::find($request->input('id'))->delete();
		}
		if(!empty($request->input('text'))){
			$records->where('name', 'like', '%'.$request->input('text').'%');
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
	    $breadcrumb = array('title'=>'Category','action'=>'Add Category');
		
		$data = [];
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
			'name' => 'required|unique:categories,name',
		];
		$request->validate($rules);
		Category::create($request->all());
		return back()->with('success', __('Record created!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
	    $breadcrumb = array('title'=>'Category','action'=>'Category Detail');
		$data = [];
        $where = array('id' => $id);
        $record = Category::where($where)->first();
		if(empty($record)){
			return redirect()->route("{$this->folder}.index")->with('warning', 'Record not found!');
		}
		$data['status'] = array(1=>'Active',0=>'In-active');
		$data['record'] = $record;
		$data = array_merge($breadcrumb,$data);
	    return view("admin.{$this->folder}.show")->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	    $breadcrumb = array('title'=>'Category','action'=>'Edit Category');
		$data = [];
        $where = array('id' => $id);
        $record = Category::where($where)->first();
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
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, Posts $posts)
    public function update(Request $request, $id)
    {
		
		$rules = [
			'name' => 'required|unique:categories,name,' . $id,
		];
		$request->validate($rules);
		$request = $request->except(['_method', '_token']);
		Category::where('id', $id)->update($request);
		return back()->with('success', __('Record updated!'));
		// return redirect()->route('posts.index')->with('success',__('Record updated!'));
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
