<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Company;
use App\Item;
use App\User;
use App\Favourite;

use App\Subject;
use Validator;
use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
  
	
	public function __construct(Request $request = null){
		
		$this->limit = Config::get('limit_api');
		$this->locale = 'api';
        
		$this->successCode = 200;
		$this->errorCode = 401;
		$this->warningCode = 500;
    }
	
	#ADD MENU ITEM
    public function index(Request $request){
	
		try {
			
			$companyData = Company::All();
			if(!empty($companyData)){
                return response()->json(['message'=>'Success', 'data' => $companyData], $this->successCode);
			}else{
                return response()->json(['message'=>'Success', 'data' => null], $this->successCode);

            }
			
		} catch (\Illuminate\Database\QueryException $exception){
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}catch(\Exception $exception){
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}
	}
	
	#ITEM DETAIL
    // public function itemDetail(Request $request){
		
	// 	$rules = [
    //         'item_id' => 'required|integer|exists:items,id',
    //     ];
		
    //     $validator = Validator::make($request->all(), $rules);
    //     if ($validator->fails()) {
    //         return response()->json(['message'=>$validator->errors()->first()], $this->warningCode);            
    //     }
		
	// 	try {
			
	// 		$itemData = Item::where(['id' => $request->item_id, 'user_id' => Auth::user()->id])->first();
			
	// 		return response()->json(['message'=>'Success', 'itemData' => $itemData], $this->successCode);
	// 	} catch (\Illuminate\Database\QueryException $exception){
	// 		$errorCode = $exception->errorInfo[1];
	// 		return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
	// 	}catch(\Exception $exception){
	// 		return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
	// 	}
	}
	
  //

