<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use App\Ride;
use App\User;
use App\DriverChooseCar;
use App\Vehicle;
use Helper;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CronController extends Controller
{
    
	public function rideAboutToStart(){
		$datetenminstime = strtotime('-10 minutes');
		$datetenmins=date('Y-m-d H:i:s', $datetenminstime);
		$dateplus12minstime = strtotime('+12 minutes');
		$date12minsplus=date('Y-m-d H:i:s', $dateplus12minstime);
		echo "10 mins before time: $datetenmins";
		echo "12 mins after time: $date12minsplus";
		//$rides=\App\Ride::where('ride_time','>=',$date)->get();
		$rides=\App\Ride::where([['ride_time', '>=', $datetenmins],['ride_type', '=', 1],['status', '=', 0],['notification_sent', '=', 0],['ride_time', '<=', $date12minsplus]])->get();
		foreach($rides as $ride){
			$rideid = $ride->id;
			 $ride= Ride::query()->where([['id', '=', $ride->id]])->first();
			 echo $ride['id'];
			 //dd($ride); die;
				//$user=$ride->user;
				$title = 'Ride is about to start';
				$message = 'Your ride is about to start in 10 minutes';
				$type=8;
				 $user_data = User::select('id','first_name','last_name','image','country_code','phone','user_type','device_type','device_token')->where('id', $ride['user_id'])->first();
		  
			
		
		$deviceToken = $user_data['device_token'];
	
		$ride['user_data'] = $user_data;
		$ride['driver_data'] = new \stdClass();
		/* echo "ride data :";
		print_r($ride); */
		$additional = ['type'=>$type,'ride_id'=>$rideid,'ride_data'=>$ride];
		
		
		echo $deviceType = $user_data['device_type'];
			if($deviceType == 'android') {
		send_notification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $user_data['id'];
		$notification->save();
			}
			if($deviceType == 'ios') {
				
		$user_type = $user_data['user_type'];
		
		echo "ios condition";
				ios_notification($title, $message, $deviceToken, $additional, $sound='default',$user_type);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $user_data['id'];
		$notification->save();
			}
			$ride= Ride::query()->where([['id', '=', $ride->id]])->first();
			$ride->notification_sent = 1;
			$ride->save();
			
		}
	}
	public function driverForScheduleRideBak(){
		//echo "driverForScheduleRide working"; die;
			$date5minsbefore = strtotime('-5 minutes');
		$newtimeberoe5mins=date('Y-m-d H:i:s', $date5minsbefore);
		$dateplus7minstime = strtotime('+7 minutes');
		$date7minsplus=date('Y-m-d H:i:s', $dateplus7minstime);
		//echo "current time: ".$date; die;
		//$rides=\App\Ride::where('ride_time','>=',$date)->get();
		$rides=\App\Ride::where([['ride_time', '>=', $newtimeberoe5mins],['ride_type', '=', 1],['status', '=', 0],['notification_sent', '=', 1],['ride_time', '<=', $date7minsplus]])->get();
		if(!empty($rides))
		{
		foreach($rides as $ride){
			echo $rideid = $ride->id;
			 $ride= Ride::query()->where([['id', '=', $ride->id]])->first();
		
			$lat = $ride['pick_lat'];
			$lon = $ride['pick_lng'];
		
		$query = User::select("users.*"
                    ,DB::raw("3959 * acos(cos(radians(" . $lat . ")) 
                    * cos(radians(users.current_lat)) 
                    * cos(radians(users.current_lng) - radians(" . $lon . ")) 
                    + sin(radians(" .$lat. ")) 
                    * sin(radians(users.current_lat))) AS distance"));
					$query->where('user_type', '=',2)->having('distance', '<', 10000)->orderBy('distance','asc');
					//$query->where('user_type', '=',2)->orderBy('distance','asc');
					$drivers = $query->get()->toArray();
					
					
	 $driverids = array();
	
			if(!empty($drivers))
			{
				foreach($drivers as $driver)
				{
					
			 
					$driverids[] = $driver['id'];
					
					
				
				}
				
			}
			else
			{
				$user_data = User::select('id','first_name','last_name','image','country_code','phone')->where('id', $ride['user_id'])->first();
		  
		
				$title = 'No Driver Found';
		$message = 'Sorry No driver found at this time for your booking';
			
		
		$deviceToken = $user_data['device_token'];
		$type = 9;
		$ride['user_data'] = new \stdClass();
		$ride['driver_data'] = new \stdClass();
		
		$additional = ['type'=>$type,'ride_id'=>$rideid,'ride_data'=>$ride];
		
		
		$deviceType = $user_data['device_type'];
			if($deviceType == 'android') {
		send_notification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
			if($deviceType == 'ios') {
				$deviceToken = $user_data['device_token'];
		$user_type = $user_data['user_type'];
		ios_notification($title, $message, $deviceToken, $additional, $sound='default',$user_type);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
			return true;
				//return response()->json(['message'=>"No Driver Found"], $this->warningCode);
			}
			if(!empty($driverids))
			{
				$driverids = implode(",",$driverids);
			}
			else
			{
				$user_data = User::select('id','first_name','last_name','image','country_code','phone')->where('id', $ride['user_id'])->first();
		  
		
				$title = 'No Driver Found';
		$message = 'Sorry No driver found at this time for your booking';
			
		
		$deviceToken = $user_data['device_token'];
		$type = 9;
		$ride['user_data'] = new \stdClass();
		$ride['driver_data'] = new \stdClass();
		
		$additional = ['type'=>$type,'ride_id'=>$rideid,'ride_data'=>$ride];
		
		
		$deviceType = $user_data['device_type'];
			if($deviceType == 'android') {
		send_notification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
			if($deviceType == 'ios') {
				$deviceToken = $user_data['device_token'];
		$user_type = $user_data['user_type'];
		ios_notification($title, $message, $deviceToken, $additional, $sound='default',$user_type);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
			return true;
				//return response()->json(['message'=>"No Driver Found"], $this->warningCode);
			}
		
		$ride->driver_id=$driverids;
		$ride->all_drivers=$driverids;
	
		 $ride->save();
		  $rideid = $ride->id;
		   $ride= Ride::query()->where([['id', '=', $rideid]])->first();
		   if(!empty($ride['ride_cost']))
		  {
		  $ride['price'] = $ride['ride_cost'];
		  }
		  $driverids = explode(",",$driverids);
		  echo "driver id are:"; print_r($driverids);
		  foreach($driverids as $driverid)
		  {
		 $driver_id = $driverid;
		  echo "driver id is: $driver_id";
		  $user_data = User::select('id','first_name','last_name','image','country_code','phone')->where('id', $ride['user_id'])->first();
		  
		  $driver_data = User::select('id','first_name','last_name','image','current_lat','current_lng','device_token','device_type','country_code','phone','user_type')->where('id', $driverid)->first();
		  $driver_car = DriverChooseCar::where('user_id', $driver_data['id'])->first();
		  $car_data = Vehicle::select('id','model','vehicle_image','vehicle_number_plate')->where('id', $driver_car['id'])->first();
		  $driver_data['car_data'] = $car_data;
				$title = 'New Booking';
		$message = 'You Received new booking';
			
		
		$deviceToken = $driver_data['device_token'];
		$type = 1;
		$ride['user_data'] = $user_data;
		$settings=\App\Setting::first();
		$settingValue=json_decode($settings['value']);
		$ride['waiting_time'] = $settingValue->waiting_time;
		/* echo "ride data :";
		print_r($ride); */
		$additional = ['type'=>$type,'ride_id'=>$rideid,'ride_data'=>$ride];
		
		
		$deviceType = $driver_data['device_type'];
			if($deviceType == 'android') {
		send_notification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
			if($deviceType == 'ios') {
				$deviceToken = $driver_data['device_token'];
				echo $user_type = $driver_data['user_type'];
				//echo "user_type id is: $user_type"; die;
		ios_notification($title, $message, $deviceToken, $additional, $sound='default',$user_type);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
		  }
		  $ride= Ride::query()->where([['id', '=', $ride->id]])->first();
			$ride->notification_sent = 2;
			$ride->save();
		}
		}
		
		// return true;
		// return response()->json(['success'=>true,'message'=>'Instant ride created successfully.','data'=>$ride],$this->successCode);
	}
	public function driverForScheduleRide(){
		//echo "driverForScheduleRide working"; die;
			die;
		$current_time=date('Y-m-d H:i:s');
		
		echo "current time: ".$current_time; 
		//$rides=\App\Ride::where('ride_time','>=',$date)->get();
		$rides=\App\Ride::where([['ride_type', '=', 1],['status', '=', 0],['alert_send', '=', 0],['ride_time', '>=', $current_time]])->get();
		if(!empty($rides))
		{
		foreach($rides as $ride){
			
			echo $rideid = $ride->id;
			 $ride= Ride::query()->where([['id', '=', $ride->id]])->first();
		$alert_time = $ride['alert_time'];
		echo "alert_time: ".$alert_time; 
		$ride_time = $ride['ride_time'];
		echo "ride_time: ".$ride_time; 
		$alert_time_notification = date("Y-m-d H:i:s", strtotime("-$alert_time minutes", strtotime($ride_time)));
		//$alert_time_notification = date("$ride_time", strtotime("-$alert_time minutes"));
		echo "alert_time_notification: ".$alert_time_notification; 
		if($current_time >= $alert_time_notification)
		{
			$lat = $ride['pick_lat'];
			$lon = $ride['pick_lng'];
		
		$query = User::select("users.*"
                    ,DB::raw("3959 * acos(cos(radians(" . $lat . ")) 
                    * cos(radians(users.current_lat)) 
                    * cos(radians(users.current_lng) - radians(" . $lon . ")) 
                    + sin(radians(" .$lat. ")) 
                    * sin(radians(users.current_lat))) AS distance"));
					$query->where('user_type', '=',2)->having('distance', '<', 10000)->orderBy('distance','asc');
					//$query->where('user_type', '=',2)->orderBy('distance','asc');
					$drivers = $query->get()->toArray();
					
					
	 $driverids = array();
	
			if(!empty($drivers))
			{
				foreach($drivers as $driver)
				{
					
			 
					$driverids[] = $driver['id'];
					
					
				
				}
				
			}
			else
			{
				$user_data = User::select('id','first_name','last_name','image','country_code','phone')->where('id', $ride['user_id'])->first();
		  
		
				$title = 'No Driver Found';
		$message = 'Sorry No driver found at this time for your booking';
			
		
		$deviceToken = $user_data['device_token'];
		$type = 9;
		$ride['user_data'] = new \stdClass();
		$ride['driver_data'] = new \stdClass();
		
		$additional = ['type'=>$type,'ride_id'=>$rideid,'ride_data'=>$ride];
		
		
		$deviceType = $user_data['device_type'];
			if($deviceType == 'android') {
		send_notification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
			if($deviceType == 'ios') {
				$deviceToken = $user_data['device_token'];
		$user_type = $user_data['user_type'];
		ios_notification($title, $message, $deviceToken, $additional, $sound='default',$user_type);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
			return true;
				//return response()->json(['message'=>"No Driver Found"], $this->warningCode);
			}
			if(!empty($driverids))
			{
				$driverids = implode(",",$driverids);
			}
			else
			{
				$user_data = User::select('id','first_name','last_name','image','country_code','phone')->where('id', $ride['user_id'])->first();
		  
		
				$title = 'No Driver Found';
		$message = 'Sorry No driver found at this time for your booking';
			
		
		$deviceToken = $user_data['device_token'];
		$type = 9;
		$ride['user_data'] = new \stdClass();
		$ride['driver_data'] = new \stdClass();
		
		$additional = ['type'=>$type,'ride_id'=>$rideid,'ride_data'=>$ride];
		
		
		$deviceType = $user_data['device_type'];
			if($deviceType == 'android') {
		send_notification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
			if($deviceType == 'ios') {
				$deviceToken = $user_data['device_token'];
		$user_type = $user_data['user_type'];
		ios_notification($title, $message, $deviceToken, $additional, $sound='default',$user_type);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
			return true;
				//return response()->json(['message'=>"No Driver Found"], $this->warningCode);
			}
		
		$ride->driver_id=$driverids;
		$ride->all_drivers=$driverids;
	
		 $ride->save();
		  $rideid = $ride->id;
		   $ride= Ride::query()->where([['id', '=', $rideid]])->first();
		   if(!empty($ride['ride_cost']))
		  {
		  $ride['price'] = $ride['ride_cost'];
		  }
		  $driverids = explode(",",$driverids);
		  echo "driver id are:"; print_r($driverids);
		  foreach($driverids as $driverid)
		  {
		 $driver_id = $driverid;
		  echo "driver id is: $driver_id";
		  $user_data = User::select('id','first_name','last_name','image','country_code','phone')->where('id', $ride['user_id'])->first();
		  
		  $driver_data = User::select('id','first_name','last_name','image','current_lat','current_lng','device_token','device_type','country_code','phone','user_type')->where('id', $driverid)->first();
		  $driver_car = \App\DriverChooseCar::where('user_id', $driver_data['id'])->first();
		  $car_data = \App\Vehicle::select('id','model','vehicle_image','vehicle_number_plate')->where('id', $driver_car['id'])->first();
		  $driver_data['car_data'] = $car_data;
				$title = 'New Booking';
		$message = 'You Received new booking';
			
		
		$deviceToken = $driver_data['device_token'];
		$type = 1;
		$ride['user_data'] = $user_data;
		$settings=\App\Setting::first();
		$settingValue=json_decode($settings['value']);
		$ride['waiting_time'] = $settingValue->waiting_time;
		/* echo "ride data :";
		print_r($ride); */
		$additional = ['type'=>$type,'ride_id'=>$rideid,'ride_data'=>$ride];
		
		
		$deviceType = $driver_data['device_type'];
			if($deviceType == 'android') {
		send_notification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
			if($deviceType == 'ios') {
				$deviceToken = $driver_data['device_token'];
				echo $user_type = $driver_data['user_type'];
				//echo "user_type id is: $user_type"; die;
		ios_notification($title, $message, $deviceToken, $additional, $sound='default',$user_type);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
		  }
		  $ride= Ride::query()->where([['id', '=', $ride->id]])->first();
			$ride->alert_send = 1;
			$ride->save();
		}
		}
		}
		// if ride not accepted by anyone then it goes to pending
		
		echo "Master schedule rides to pendings if not accepted";
		$alert_rides=\App\Ride::where([['ride_type', '=', 1],['alert_send', '=', 1],['status', '=', 0],['ride_time', '>', $current_time]])->get();
		print_r($alert_rides);
		if(!empty($alert_rides))
		{
		foreach($alert_rides as $alert_ride){
			echo "alert ride id: "; echo $rideid = $alert_ride->id;
			 $ride= Ride::query()->where([['id', '=', $alert_ride->id]])->first();
			 $rideid = $alert_ride->id;
			 $ride_data= Ride::query()->where([['id', '=', $alert_ride->id]])->first();
			 $alert_time = $ride['alert_time'];
		echo "alert_time: ".$alert_time; 
		$ride_time = $ride['ride_time'];
		echo "ride_time: ".$ride_time; 
		$alert_time_notification = date("Y-m-d H:i:s", strtotime("-$alert_time minutes", strtotime($ride_time)));
		//$alert_time_notification = date("$ride_time", strtotime("-$alert_time minutes"));
		echo "alert_time_notification: ".$alert_time_notification; 
		$alert_time_notificationplusone = date("Y-m-d H:i:s", strtotime("+1 minutes", strtotime($alert_time_notification)));
		if($current_time >= $alert_time_notificationplusone)
		{
			if($ride['status'] == 0)
			{
				$master_drivers = User::query()->where([['user_type', '=', 2],['is_master', '=', 1]])->get()->toArray();
			 $driverids = array();
			if(!empty($master_drivers))
			{
				foreach($master_drivers as $master_driver)
				{
					$ride= Ride::query()->where([['id', '=', $alert_ride->id]])->first();
					
					//$ride->status=-4;
		//print_r($input); die;
		$ride->save();
			 
					$driverids[] = $master_driver['id'];
					
				
				}
				
			}
				if(!empty($driverids))
			{
				//$driverids = explode(",",$driverids);
				echo "driver id:";
		  print_r($driverids);
		  /* echo "ride data :";
		print_r($ride_data); die; */
		  foreach($driverids as $driverid)
		  {
		  $driver_id = $driverid;
		  $user_data = User::select('id','first_name','last_name','image','country_code','phone')->where('id', $ride_data['user_id'])->first();
		  
		  $driver_data = User::select('id','first_name','last_name','image','current_lat','current_lng','device_token','device_type','country_code','phone','user_type')->where('id', $driverid)->first();
		  $driver_car = \App\DriverChooseCar::where('user_id', $driver_data['id'])->first();
		  $car_data = \App\Vehicle::select('id','model','vehicle_image','vehicle_number_plate')->where('id', $driver_car['id'])->first();
		  $driver_data['car_data'] = $car_data;
				$title = 'Pending Ride';
		$message = 'No Driver Accepted Ride';
			
		
		$deviceToken = $driver_data['device_token'];
		$type = 9;
		$ride_data['user_data'] = $user_data;
		$settings=\App\Setting::first();
		$settingValue=json_decode($settings['value']);
		$ride_data['waiting_time'] = $settingValue->waiting_time;
		/* echo "ride data :";
		print_r($ride); */
		$additional = ['type'=>$type,'ride_id'=>$rideid,'ride_data'=>$ride_data];
		
		
		$deviceType = $driver_data['device_type'];
			if($deviceType == 'android') {
		send_notification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
			if($deviceType == 'ios') {
				/* $deviceToken = $driver_data['device_token'];
		send_iosnotification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]); */
		$user_type = $driver_data['user_type'];
		
		/* echo "Driver id : ".$driver_data['id'];
		echo "User type : $user_type"; */
				ios_notification($title, $message, $deviceToken, $additional, $sound='default',$user_type);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
		  }
			}
			}
		}
		
		}
		}
		
		echo "instant ride Part";
		$instant_rides=\App\Ride::where([['ride_type', '=', 3],['status', '=', 0],['ride_time', '<', $current_time]])->get();
		//print_r($instant_rides);
		if(!empty($instant_rides))
		{
		foreach($instant_rides as $instant_ride){
		 
			$ride= Ride::query()->where([['id', '=', $instant_ride->id]])->first();
			$rideid = $instant_ride->id;
		echo $ride_time = $instant_ride['ride_time'];
		$ride_time = date("Y-m-d H:i:s", strtotime("+30 seconds", strtotime($ride_time)));
		echo "ride id".$ride['id'];
		if($current_time > $ride_time)
		{
			if($ride['status'] == 0)
			{
				$master_drivers = User::query()->where([['user_type', '=', 2],['is_master', '=', 1]])->get()->toArray();
			 $driverids = array();
			if(!empty($master_drivers))
			{
				foreach($master_drivers as $master_driver)
				{
					$ride= Ride::query()->where([['id', '=', $instant_ride->id]])->first();
					$ride_data= Ride::query()->where([['id', '=', $instant_ride->id]])->first();
					// $ride->status=-4;
		//print_r($input); die;
		$ride->save();
			 
					$driverids[] = $master_driver['id'];
					
				
				}
				
			}
			
				if(!empty($driverids))
			{
				//$driverids = explode(",",$driverids);
				echo "driver id:";
		  print_r($driverids);
		  /* echo "ride data :";
		print_r($ride_data); die; */
		  foreach($driverids as $driverid)
		  {
		  $driver_id = $driverid;
		  $user_data = User::select('id','first_name','last_name','image','country_code','phone')->where('id', $ride_data['user_id'])->first();
		  
		  $driver_data = User::select('id','first_name','last_name','image','current_lat','current_lng','device_token','device_type','country_code','phone','user_type')->where('id', $driverid)->first();
		  $driver_car = \App\DriverChooseCar::where('user_id', $driver_data['id'])->first();
		  $car_data = \App\Vehicle::select('id','model','vehicle_image','vehicle_number_plate')->where('id', $driver_car['id'])->first();
		  $driver_data['car_data'] = $car_data;
				$title = 'Pending Ride';
		$message = 'No Driver Accepted Ride';
			
		
		$deviceToken = $driver_data['device_token'];
		$type = 9;
		$ride_data['user_data'] = $user_data;
		$settings=\App\Setting::first();
		$settingValue=json_decode($settings['value']);
		$ride_data['waiting_time'] = $settingValue->waiting_time;
		/* echo "ride data :";
		print_r($ride); */
		$additional = ['type'=>$type,'ride_id'=>$rideid,'ride_data'=>$ride_data];
		
		
		$deviceType = $driver_data['device_type'];
			if($deviceType == 'android') {
		send_notification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
			if($deviceType == 'ios') {
				/* $deviceToken = $driver_data['device_token'];
		send_iosnotification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]); */
		$user_type = $driver_data['user_type'];
		
		/* echo "Driver id : ".$driver_data['id'];
		echo "User type : $user_type"; */
				ios_notification($title, $message, $deviceToken, $additional, $sound='default',$user_type);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
		  }
			}
			}
		}
		}
		}
		
		
		// return true;
		// return response()->json(['success'=>true,'message'=>'Instant ride created successfully.','data'=>$ride],$this->successCode);
	}
public function shareRideExecute(){
		//echo "shareRideExecute working"; die;
			
		$current_time=date('Y-m-d H:i:s');
		
		echo "current time: ".$current_time;
		//$rides=\App\Ride::where('ride_time','>=',$date)->get();
		$rides=\App\Ride::where([['ride_type', '=', 4],['actual_share_ride', '=', 1],['status', '=', 0],['alert_send', '=', 0],['ride_time', '>=', $current_time]])->get();
	
		if(!empty($rides))
		{
		foreach($rides as $ride){
			
			echo $rideid = $ride->id;
			 $ride= Ride::query()->where([['id', '=', $ride->id]])->first();
			 
			 
			 
		$alert_time = 10;
		echo "alert_time: ".$alert_time; 
		$ride_time = $ride['ride_time'];
		echo "ride_time: ".$ride_time; 
		$alert_time_notification = date("Y-m-d H:i:s", strtotime("-$alert_time minutes", strtotime($ride_time)));
		//$alert_time_notification = date("$ride_time", strtotime("-$alert_time minutes"));
		echo "alert_time_notification: ".$alert_time_notification; 
		if($current_time >= $alert_time_notification)
		{
			$lat = $ride['pick_lat'];
			$lon = $ride['pick_lng'];
		
		$query = User::select("users.*"
                    ,DB::raw("3959 * acos(cos(radians(" . $lat . ")) 
                    * cos(radians(users.current_lat)) 
                    * cos(radians(users.current_lng) - radians(" . $lon . ")) 
                    + sin(radians(" .$lat. ")) 
                    * sin(radians(users.current_lat))) AS distance"));
					$query->where('user_type', '=',2)->having('distance', '<', 10000)->orderBy('distance','asc');
					//$query->where('user_type', '=',2)->orderBy('distance','asc');
					$drivers = $query->get()->toArray();
					
					
	 $driverids = array();
	
			if(!empty($drivers))
			{
				foreach($drivers as $driver)
				{
					
			 
					$driverids[] = $driver['id'];
					
					
				
				}
				
			}
			else
			{
				$user_data = User::select('id','first_name','last_name','image','country_code','phone')->where('id', $ride['user_id'])->first();
		  
		
				$title = 'No Driver Found';
		$message = 'Sorry No driver found at this time for your booking';
			
		
		$deviceToken = $user_data['device_token'];
		$type = 9;
		$ride['user_data'] = new \stdClass();
		$ride['driver_data'] = new \stdClass();
		
		$additional = ['type'=>$type,'ride_id'=>$rideid,'ride_data'=>$ride];
		
		
		$deviceType = $user_data['device_type'];
			if($deviceType == 'android') {
		send_notification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
			if($deviceType == 'ios') {
				$deviceToken = $user_data['device_token'];
		$user_type = $user_data['user_type'];
		ios_notification($title, $message, $deviceToken, $additional, $sound='default',$user_type);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
			return true;
				//return response()->json(['message'=>"No Driver Found"], $this->warningCode);
			}
			if(!empty($driverids))
			{
				$driverids = implode(",",$driverids);
			}
			else
			{
				$user_data = User::select('id','first_name','last_name','image','country_code','phone')->where('id', $ride['user_id'])->first();
		  
		
				$title = 'No Driver Found';
		$message = 'Sorry No driver found at this time for your booking';
			
		
		$deviceToken = $user_data['device_token'];
		$type = 9;
		$ride['user_data'] = new \stdClass();
		$ride['driver_data'] = new \stdClass();
		
		$additional = ['type'=>$type,'ride_id'=>$rideid,'ride_data'=>$ride];
		
		
		$deviceType = $user_data['device_type'];
			if($deviceType == 'android') {
		send_notification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
			if($deviceType == 'ios') {
				$deviceToken = $user_data['device_token'];
		$user_type = $user_data['user_type'];
		ios_notification($title, $message, $deviceToken, $additional, $sound='default',$user_type);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
			return true;
				//return response()->json(['message'=>"No Driver Found"], $this->warningCode);
			}
		
		$ride->driver_id=$driverids;
		$ride->all_drivers=$driverids;
	
		 $ride->save();
		  $rideid = $ride->id;
		   $ride= Ride::query()->where([['id', '=', $rideid]])->first();
		   if(!empty($ride['ride_cost']))
		  {
		  $ride['price'] = $ride['ride_cost'];
		  }
		  $driverids = explode(",",$driverids);
		  echo "driver id are:"; print_r($driverids);
		  foreach($driverids as $driverid)
		  {
		 $driver_id = $driverid;
		  echo "driver id is: $driver_id";
		  $user_data = User::select('id','first_name','last_name','image','country_code','phone')->where('id', $ride['user_id'])->first();
		  
		  $driver_data = User::select('id','first_name','last_name','image','current_lat','current_lng','device_token','device_type','country_code','phone','user_type')->where('id', $driverid)->first();
		  $driver_car = \App\DriverChooseCar::where('user_id', $driver_data['id'])->first();
		  $car_data = \App\Vehicle::select('id','model','vehicle_image','vehicle_number_plate')->where('id', $driver_car['id'])->first();
		  $driver_data['car_data'] = $car_data;
				$title = 'New Booking';
		$message = 'You Received new booking';
			
		
		$deviceToken = $driver_data['device_token'];
		$type = 1;
		$ride['user_data'] = $user_data;
		$settings=\App\Setting::first();
		$settingValue=json_decode($settings['value']);
		$ride['waiting_time'] = $settingValue->waiting_time;
		/* echo "ride data :";
		print_r($ride); */
		$additional = ['type'=>$type,'ride_id'=>$rideid,'ride_data'=>$ride];
		
		
		$deviceType = $driver_data['device_type'];
			if($deviceType == 'android') {
		send_notification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
			if($deviceType == 'ios') {
				$deviceToken = $driver_data['device_token'];
				echo $user_type = $driver_data['user_type'];
				//echo "user_type id is: $user_type"; die;
		ios_notification($title, $message, $deviceToken, $additional, $sound='default',$user_type);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
		  }
		  $ride= Ride::query()->where([['id', '=', $ride->id]])->first();
			$ride->alert_send = 1;
			$ride->save();
		}
		}
		}
		// if ride not accepted by anyone then it goes to pending
		
		echo "Master schedule rides to pendings if not accepted";
		$alert_rides=\App\Ride::where([['ride_type', '=', 4],['actual_share_ride', '=', 1],['alert_send', '=', 1],['status', '=', 0],['ride_time', '>', $current_time]])->get();
		print_r($alert_rides);
		if(!empty($alert_rides))
		{
		foreach($alert_rides as $alert_ride){
			echo "alert ride id: "; echo $rideid = $alert_ride->id;
			 $ride= Ride::query()->where([['id', '=', $alert_ride->id]])->first();
			 $rideid = $alert_ride->id;
			 $ride_data= Ride::query()->where([['id', '=', $alert_ride->id]])->first();
			 $alert_time = 10;
		echo "alert_time: ".$alert_time; 
		$ride_time = $ride['ride_time'];
		echo "ride_time: ".$ride_time; 
		
	
		$alert_time_notification = date("Y-m-d H:i:s", strtotime("-$alert_time minutes", strtotime($ride_time)));
		//$alert_time_notification = date("$ride_time", strtotime("-$alert_time minutes"));
		echo "alert_time_notification: ".$alert_time_notification; 
		$alert_time_notificationplusone = date("Y-m-d H:i:s", strtotime("+1 minutes", strtotime($alert_time_notification)));
		
		
		if($current_time >= $alert_time_notificationplusone)
		{
			if($ride['status'] == 0)
			{
				$master_drivers = User::query()->where([['user_type', '=', 2],['is_master', '=', 1]])->get()->toArray();
			 $driverids = array();
			if(!empty($master_drivers))
			{
				foreach($master_drivers as $master_driver)
				{
					$ride= Ride::query()->where([['id', '=', $alert_ride->id]])->first();
					
					// $ride->status=-4;
		//print_r($input); die;
		$ride->save();
			 
					$driverids[] = $master_driver['id'];
					
				
				}
				
			}
				if(!empty($driverids))
			{
				//$driverids = explode(",",$driverids);
				echo "driver id:";
		  print_r($driverids);
		  /* echo "ride data :";
		print_r($ride_data); die; */
		  foreach($driverids as $driverid)
		  {
		  $driver_id = $driverid;
		  $user_data = User::select('id','first_name','last_name','image','country_code','phone')->where('id', $ride_data['user_id'])->first();
		  
		  $driver_data = User::select('id','first_name','last_name','image','current_lat','current_lng','device_token','device_type','country_code','phone','user_type')->where('id', $driverid)->first();
		  $driver_car = \App\DriverChooseCar::where('user_id', $driver_data['id'])->first();
		  $car_data = \App\Vehicle::select('id','model','vehicle_image','vehicle_number_plate')->where('id', $driver_car['id'])->first();
		  $driver_data['car_data'] = $car_data;
				$title = 'Pending Ride';
		$message = 'No Driver Accepted Ride';
			
		
		$deviceToken = $driver_data['device_token'];
		$type = 9;
		$ride_data['user_data'] = $user_data;
		$settings=\App\Setting::first();
		$settingValue=json_decode($settings['value']);
		$ride_data['waiting_time'] = $settingValue->waiting_time;
		/* echo "ride data :";
		print_r($ride); */
		$additional = ['type'=>$type,'ride_id'=>$rideid,'ride_data'=>$ride_data];
		
		
		$deviceType = $driver_data['device_type'];
			if($deviceType == 'android') {
		send_notification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
			if($deviceType == 'ios') {
				/* $deviceToken = $driver_data['device_token'];
		send_iosnotification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]); */
		$user_type = $driver_data['user_type'];
		
		/* echo "Driver id : ".$driver_data['id'];
		echo "User type : $user_type"; */
				ios_notification($title, $message, $deviceToken, $additional, $sound='default',$user_type);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
		  }
			}
			}
		}
		
		}
		}
		
		
		
		
		// return true;
		// return response()->json(['success'=>true,'message'=>'Instant ride created successfully.','data'=>$ride],$this->successCode);
	}
	public function autoCancel(){
		
		//$rides=\App\Ride::where('ride_time','>=',$date)->get();
		$rides=\App\Ride::whereDate('ride_time', '<', Carbon::today())->where(function($query) {
			$query->where([['status', '=', 0]])->orWhere([['status', '=', 1]])->orWhere([['status', '=', 2]])->orWhere([['status', '=', 4]]);
})->get(); 
//echo json_encode($rides); die;
		foreach($rides as $ride){
			
			
			$ride= Ride::query()->where([['id', '=', $ride->id]])->first();
			$ride->status = -5;
			$ride->save();
			
		}
	}
	  public function notification()
    {
		$driverids = $_GET['driverids'];
		$rideid = $_GET['ride_id'];
		$ride_data= Ride::query()->where([['id', '=', $rideid]])->first();
        //
		 $driverids = explode(",",$driverids);
		  /* echo "ride data :";
		print_r($ride_data); die; */
		  foreach($driverids as $driverid)
		  {
		  $driver_id = $driverid;
		  $user_data = User::select('id','first_name','last_name','image','country_code','phone')->where('id', $ride_data['user_id'])->first();
		  
		  $driver_data = User::select('id','first_name','last_name','image','current_lat','current_lng','device_token','device_type','country_code','phone','user_type')->where('id', $driverid)->first();
		  $driver_car = DriverChooseCar::where('user_id', $driver_data['id'])->first();
		  $car_data = Vehicle::select('id','model','vehicle_image','vehicle_number_plate')->where('id', $driver_car['id'])->first();
		  $driver_data['car_data'] = $car_data;
				$title = 'New Booking';
		$message = 'You Received new booking';
			
		
		$deviceToken = $driver_data['device_token'];
		$type = 1;
		$ride_data['user_data'] = $user_data;
		$settings=\App\Setting::first();
		$settingValue=json_decode($settings['value']);
		$ride_data['waiting_time'] = $settingValue->waiting_time;
		
		$additional = ['type'=>$type,'ride_id'=>$rideid,'ride_data'=>$ride_data];
		
		
		$deviceType = $driver_data['device_type'];
			if($deviceType == 'android') {
			
		send_notification($title, $message, $deviceToken, '',$additional,true,false,$deviceType,[]);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
			if($deviceType == 'ios') {
				
		$user_type = $driver_data['user_type'];
		
		
				ios_notification($title, $message, $deviceToken, $additional, $sound='default',$user_type);
		$notification = new Notification();
		$notification->title = $title;
		$notification->description = $message;
		$notification->type = $type;
		$notification->user_id = $driver_data['id'];
		$notification->save();
			}
		  }
		 
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
	public function testing()
    {
		echo "testing"; die;
        //
    }
}
