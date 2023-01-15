<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Ride;
use Carbon\Carbon;
use Validator;

class RideController extends Controller
{
   /**
     * Created By Anil Dogra
     * Created At 28-07-2022
     * @var $request object of request class
     * @var $user object of user class
     * @return object after send reset password token
     * This function use to list of latest ride detail
     */

    public function latest_ride_detail(Request $request)
    {
        $userObj = Auth::user();
        if (!$userObj) {
            return $this->notAuthorizedResponse('User is not authorized');
        }
        $ride = Ride::with(['user', 'driver', 'company_data'])->where('driver_id', $userObj->id)->where(function ($query) {
            $query->where(['status' => 1])->orWhere(['status' => 2])->orWhere(['status' => 4]);
        })->orderBy('ride_time')->get();
        return $this->successResponse($ride, 'Get latest ride successfully');
    }
    /**
     * Created By Anil Dogra
     * Created At 28-07-2022
     * @var $request object of request class
     * @var $user object of user class
     * @return object after send reset password token
     * This function use to list of latest ride detail
     */
 
    public function driverUpdateLocation(Request $request){
      
        $userObj = Auth::user();
         
        if (!$userObj) {
            return $this->notAuthorizedResponse('User is not authorized');
        }
         
         $rules = [
            'latitude' => 'required',
            'longitude' => 'required',
          
        ];
        
        $inputArr = $request->all();
        $validator = Validator::make($inputArr, $rules);
        if ($validator->fails()) {
            $validateerror = $validator->errors()->all();
            return $this->validationErrorResponse($validateerror[0]);
        }

          $updateUser['current_lat']=($inputArr['latitude'])?$inputArr['latitude']:null;
          $updateUser['current_lng']=($inputArr['longitude'])?$inputArr['longitude']:null;
              
        $hasUpdate = $userObj->updateUser($userObj->id, $updateUser);  
          
          if($hasUpdate){

              return $this->successResponse([], 'Location updated successfully!');
            }
        
        return $this->notAuthorizedResponse('Something went wrong.');


    }

    public function getRideList(Request $request,Ride $rides){
        $userObj = Auth::user();
         // print_r($userObj);die;
        if (!$userObj) {
            return $this->notAuthorizedResponse('User is not authorized');
        }
                 
         $rules = [
            'type' => 'required',
            // 'longitude' => 'required',
          
        ];
        
        $inputArr = $request->all();
        $validator = Validator::make($inputArr, $rules);
        if ($validator->fails()) {
            $validateerror = $validator->errors()->all();
            return $this->validationErrorResponse($validateerror[0]);
        }
         $inputArr = $request->all();
        $typeArr=array(1,2,3);
        if(!in_array($inputArr['type'],$typeArr)){
            return $this->validationErrorResponse('Please enter valid type.');
        }
       
        $limit = 10;  //set  Number of entries to show in a page.
            // Look for a GET variable page if not found default is 1.        
            if (isset($inputArr["page"])) {    
            $page  = $inputArr["page"];    
            }    
            else { $page=1;    
            }
          //determine the sql LIMIT starting number for the results on the displaying page  
            $inputArr['page_index'] = ($page-1) * $limit;      // 0
             $inputArr['limit'] = $limit;
            $queryData=$rides->getRideHistory($userObj,$inputArr);

            $currentData = array();
        foreach ($queryData as $value) {
            $data = $value->getRideList();
            array_push($currentData,(object)$data);
        }

        $user_count=count($currentData); 
                
            $total_records = $user_count;   //9
            $total_pages = ceil($total_records / $limit); 
        $arrayData=array('data_count'=>$user_count,'total'=>$total_pages,'per_page'=>$limit,'current_page'=>$page,'data'=>$currentData);   

             return $this->successResponse($arrayData, 'Get ride list successfully');  
    }

}
