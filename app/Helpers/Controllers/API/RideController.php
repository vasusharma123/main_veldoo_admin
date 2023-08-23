<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
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
 
    public function latest_ride_detail(Request $request){
      
        $userObj = Auth::user();
         
        if (!$userObj) {
            return $this->notAuthorizedResponse('User is not authorized');
        }

       $ride = Ride::where('driver_id',$userObj->id)->whereDate('created_at', Carbon::today())->whereIn('status',[1,2,4])->orderBy('id', 'DESC')->first();
       
	   // $ride['user_data'] = User::select('id', 'first_name', 'last_name', 'image', 'country_code', 'phone')->where('id', $ride['user_id'])->first();

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

}
