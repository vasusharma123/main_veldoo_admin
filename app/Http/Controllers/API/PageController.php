<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Page;
use Validator;
use Config;

class PageController extends Controller{
	
	public function __construct(Request $request = null){
		
		$this->limit = Config::get('limit_api');
		$this->locale = 'api';
		$this->successCode = 200;
		$this->errorCode = 401;
		$this->warningCode = 500;
    }
	
	public function page(Request $request){
		
		$rules = [
            'type' => 'required|integer|exists:pages,id',
        ];
		
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->first(),'error'=>$validator->errors()], $this->warningCode);            
        }
		
		$data = Page::where(['id' => $request->type])->first();
		try {
			return response()->json(['message'=>trans('api.list_data'), 'data' => $data], $this->successCode);
		} catch (\Illuminate\Database\QueryException $exception){
			$errorCode = $exception->errorInfo[1];
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}catch(\Exception $exception){
			return response()->json(['message'=>$exception->getMessage()], $this->warningCode);
		}
	}
}
?>