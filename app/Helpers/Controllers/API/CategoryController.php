<?php
namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Item;
use App\User;
use App\Favourite;

use App\Subject;
use Validator;
use Config;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller{
	
	public function __construct(Request $request = null){
		
		$this->limit = Config::get('limit_api');
		$this->locale = 'api';
        
		$this->successCode = 200;
		$this->errorCode = 401;
		$this->warningCode = 500;
    }
	
	#ADD MENU ITEM
    public function addItem(Request $request){
		
		$rules = [
			'name' => 'required',
			'price' => 'required|between:0,99.99',
            'cat_name' => 'required',
            'qty' => 'required|integer',
			'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
		
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['message'=>trans('api.required_data'),'error'=>$validator->errors()], $this->warningCode);            
        }
		
		try {
			
			$catData = Category::where('name', $request->cat_name)->first();
			if($catData){
				$cat_id = $catData->id;
			}else{
				$saveCat['name'] = $request->cat_name;
				$saveCat['status'] = 1;
				
				$catData = Category::create($saveCat);
				$cat_id = $catData->id;
			}
			
			$itemData['user_id'] = Auth::user()->id;
			$itemData['name'] = $request->name;
			$itemData['cat_id'] = $cat_id;
			$itemData['cat_name'] = $request->cat_name;
			$itemData['qty'] = $request->qty;
			$itemData['price'] = $request->price;
			
			$itemSaved = Item::create($itemData);
			if($itemSaved->id){
				if($request->hasFile('image') && $request->file('image')->isValid()){
					
					$imgName = Storage::disk('public')->putFileAs(
						'items/'.$itemSaved->id, $request->file('image'),'item-image.'.$request->image->extension()
					);
					
					$itemData = Item::where('id', $itemSaved->id)->first();
					$itemData->image = $imgName;
					$itemData->save();
				}
			}
			
			return response()->json(['message'=>'Added successfully'], $this->successCode);
			
		} catch (\Illuminate\Database\QueryException $exception){
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}catch(\Exception $exception){
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}
	}
	
	#ITEM DETAIL
    public function itemDetail(Request $request){
		
		$rules = [
            'item_id' => 'required|integer|exists:items,id',
        ];
		
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->first()], $this->warningCode);            
        }
		
		try {
			
			$itemData = Item::where(['id' => $request->item_id, 'user_id' => Auth::user()->id])->first();
			
			return response()->json(['message'=>'Success', 'itemData' => $itemData], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception){
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}catch(\Exception $exception){
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}
	}
	
	#UPDATE MENU ITEM
    public function updateItem(Request $request){
		
		$rules = [
            'cat_name' => 'required|exists:categories,name',
            'item_id' => 'required|integer|exists:items,id',
        ];
		
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->first()], $this->warningCode);            
        }
		
		try {
			
			$catData = Category::where('name', $request->cat_name)->first();
			$itemData = Item::where(['id' => $request->item_id, 'user_id' => Auth::user()->id])->first();
			
			if(!empty($itemData)){
				
				$itemData->cat_id = $catData->id;
				$itemData->cat_name = $catData->name;
				
				if(!empty($request->name)){
					$itemData->name = $request->name;
				}
				
				if(!empty($request->qty)){
					$itemData->qty = $request->qty;
				}
				
				if(!empty($request->price)){
					$itemData->price = $request->price;
				}
				
				if($request->hasFile('image') && $request->file('image')->isValid()){
					
					$imgName = Storage::disk('public')->putFileAs(
						'items/'.$itemData->id, $request->file('image'),'item-image.'.$request->image->extension()
					);
					
					$itemData->image = $imgName;
				}
				$itemData->save();
				
				return response()->json(['message'=>'Updated successfully'], $this->successCode);
			}else{
				return response()->json(['message'=>'Error'], $this->warningCode);
			}
		} catch (\Illuminate\Database\QueryException $exception){
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}catch(\Exception $exception){
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}
	}
	
	#DELETE ITEM
	public function deleteItem(Request $request){
		
		$rules = [
            'item_id' => 'required|integer|exists:items,id',
        ];
		
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->first()], $this->warningCode);            
        }
		
		try {
			\App\Item::find($request->item_id)->delete();
			
			return response()->json(['message'=>'Deleted successfully'], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception){
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}catch(\Exception $exception){
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}
	}
	
	#CATEGORIES LIST
	public function categoriesList(Request $request){
		
		$cats = Category::where(['status' => 1])->orderBy('id', 'DESC');
		
		$cats = $cats->paginate($this->limit);
		
		try {
			return response()->json(['message'=>trans('api.list_data'), 'cats' => $cats], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception){
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}catch(\Exception $exception){
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}
	}
	
	#ITEMS LIST
	public function itemsList(Request $request){
		
		//$items = Item::where(['user_id' => Auth::user()->id])->orderBy('id', 'DESC');
		$items = Category::where(['status' => 1])->with(['itemList'])->orderBy('id', 'DESC');
		
		$items = $items->paginate($this->limit);
		//print_r(json_encode($items)); die;
		//dd($items); die;
		/* echo "<pre>";
		var_dump($items); die; */
		$itemsnew = "";
		$itemsnew2 = "";
		$i = 0;
		if(!empty($items))
		{
			$itemsjson = json_encode($items);
			$itemsjson = json_decode($itemsjson);
			/* print_r($itemsjson); die;
			echo $itemsjson->current_page; die; */
			$itemsloop = $itemsjson->data;
			$itemsnew2 = $items;
			$itemsnew2->data = array();
			//print_r($itemsnew); die;
			foreach($itemsloop as $it)
		{ 
			//print_r($it['data']); die;
			if(!empty($it->item_list))
			{
			$itemsnew->data[$i] = $it;
			$i++;
				/* $itemsnew[$i]['data'] = $it;
				$i++;  */
			} 
		}
		}
	
		
		
		 
		try {
			return response()->json(['message'=>'Success', 'items' => $itemsnew,'newitems'=>$itemsnew], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception){
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}catch(\Exception $exception){
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}
	}
	
	#ITEMS LIST BY CATEGORY
	public function searchItems(Request $request){
		
		$rules = [
            'cat_name' => 'required',
        ];
		
		$validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->first()], $this->warningCode);            
        }
		
		$items = Item::where(['user_id' => Auth::user()->id])->orderBy('id', 'DESC');
		$cat_name = $request->cat_name;
		$items->where([['cat_name', 'LIKE', "%$cat_name%"]]);
		
		$items = $items->paginate($this->limit);
		
		try {
			return response()->json(['message'=>'Success', 'items' => $items], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception){
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}catch(\Exception $exception){
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}
	}
	
	#SUBJECTS LIST
	public function subjectsList(Request $request){
		
		$subjects = Subject::orderBy('id', 'DESC');
		
		$subjects = $subjects->paginate($this->limit);
		
		try {
			return response()->json(['message'=>'Success', 'subjects' => $subjects], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception){
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}catch(\Exception $exception){
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}
	}
	public function driverItemsList(Request $request){
		$user = Auth::user();
			$user_id = $user['id'];
		 if(!empty($_REQUEST['driver_id']) || !empty($_REQUEST['lat']) || !empty($_REQUEST['category_id']))
		 {
			 if(!empty($_REQUEST['driver_id']))
		 {
		if(!empty($_REQUEST['search']))
		 {
			 $items = Item::where(['user_id' => $_REQUEST['driver_id']])->where('name', 'like', '%' . $_REQUEST['search'] . '%')->orderBy('id', 'DESC');
		 }
		else
		{
		$items = Item::where(['user_id' => $_REQUEST['driver_id']])->orderBy('id', 'DESC');
		}
		 }
		 if(!empty($_REQUEST['lat']) && !empty($_REQUEST['lng']))
		 {
		
			  $lat = $_REQUEST['lat'];
            $lon = $_REQUEST['lng'];
			
			/* $query = User::select("users.*"
                    ,DB::raw("3959 * acos(cos(radians(" . $lat . ")) 
                    * cos(radians(users.lat)) 
                    * cos(radians(users.lng) - radians(" . $lon . ")) 
                    + sin(radians(" .$lat. ")) 
                    * sin(radians(users.lat))) AS distance"));
					$query->where('user_type', '=',3)->having('distance', '<', 2000)->orderBy('distance','asc');
					$items = Item::where(['user_id' => $_REQUEST['driver_id']])->orderBy('id', 'DESC');
					$resnewarray = $query->get()->toArray();
	 
			if(!empty($resnewarray))
			{
				$i = 0;
			$userids = array();
			foreach($resnewarray as $result)
			{
				
				$userids[] = $result['id'];
				$i++;
			}
			} */
			if(!empty($_REQUEST['search']))
		 {
			 
			// $query = Item::query();
			//$items = Item::where(['user_id' => $userids])->where('name', 'like', '%' . $_REQUEST['search'] . '%')->orderBy('id', 'DESC');
			//$items = Item::where('name', 'like', '%' . $_REQUEST['search'] . '%')->orderBy('id', 'DESC');
			//$items = Category::where(['status' => 1])->orderBy('id', 'DESC');
			$cats = DB::select("SELECT * FROM categories where status = 1");
		 }
		else
		{
			
			//$items = Item::orderBy('id', 'DESC');
			//$items = Category::where(['status' => 1])->orderBy('id', 'DESC');
			$cats = DB::select("SELECT * FROM categories where status = 1");
		}
		 }
		 if(!empty($_REQUEST['category_id']))
		 {
			 $cat_id = $_REQUEST['category_id'];
			 $cats = DB::select("SELECT * FROM categories where id = $cat_id");
		 }
		// print_r($items); die;
		//$items = Category::where(['status' => 1])->with(['itemList'])->orderBy('id', 'DESC');
		
		//$items = $items->paginate($this->limit);
		$cats=array_map(function($item){
    return (array) $item;
},$cats);
		$itemsnew = array();
		$i= 0;
		foreach($cats as $cat)
		{
		
		$cat_id = $cat['id'];
		if(!empty($_REQUEST['search']))
		 {
			 if(!empty($_REQUEST['category_id']))
		 {
			 $search = $_REQUEST['search'];
		$items = DB::select("SELECT * FROM items where cat_id = $cat_id and (name like '%$search%' or cat_name like '%$search%')");
		 }
		 else
		 {
			  $search = $_REQUEST['search'];
		$items = DB::select("SELECT * FROM items where cat_id = $cat_id and (name like '%$search%' or cat_name like '%$search%') limit 6");
		 }
		 }
		 else
		 {
			 if(!empty($_REQUEST['category_id']))
		 {
			 $items = DB::select("SELECT * FROM items where cat_id = $cat_id");
		 }
		 else
		 {
			 $items = DB::select("SELECT * FROM items where cat_id = $cat_id limit 6");
		 }
		 }
		$items=array_map(function($item){
    return (array) $item;
},$items);
		if(!empty($items))
		{
			$itemsnew[$i] = $cat;
			$j = 0;
			foreach($items as $it)
			{
				
				$itemsnew[$i]['items'][$j] = $it;
				$fav = Favourite::query()->where([['user_id', '=', $user_id],['item_id', '=', $it['id']],['status', '=', 1]])->first();
			if(!empty($fav))
			{
				$itemsnew[$i]['items'][$j]['fav'] = '1';
			}
			else
			{
				$itemsnew[$i]['items'][$j]['fav'] = '0';
			}
				$itemsnew[$i]['items'][$j]['driver_data'] = User::find($it['user_id']);
				if($itemsnew[$i]['items'][$j]['driver_data']['current_lat'] == null)
				{
					$itemsnew[$i]['items'][$j]['driver_data']['current_lat'] = "";
				}
				if($itemsnew[$i]['items'][$j]['driver_data']['current_lng'] == null)
				{
					$itemsnew[$i]['items'][$j]['driver_data']['current_lng'] = "";
				}
				$j++;
			}
			
			
			$i++;
		}
		//$itemnew[$i]['driver_data'] = User::find($item['driver_id']);
		
		}
		
		try {
			return response()->json(['message'=>'Success', 'items' => $itemsnew], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception){
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}catch(\Exception $exception){
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}
		}
		 else
		 {
			return response()->json(['message'=>'Please fill all required fields'], $this->warningCode);
		 }
	}
}
?>