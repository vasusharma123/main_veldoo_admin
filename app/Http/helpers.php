<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Str;
use Pushok\AuthProvider;
use Pushok\Client;
use Pushok\Notification;
use Pushok\Payload;
use Pushok\Payload\Alert;
use Edujugon\PushNotification\PushNotification;

function ios_notification($title, $body, $deviceTokens, $additional=array(), $sound='default',$user_type)
	{
		/* print_r($additional); die;
		echo "User type helper : $user_type"; */
		if($user_type == 2)
		{
		$options = [
			'key_id' => 'T5U8YFRV99', // The Key ID obtained from Apple developer account
			'team_id' => '3J97M57G62', // The Team ID obtained from Apple developer account
			'app_bundle_id' => 'app.com.Veldoo', // com.orem.Modo-Provider The bundle ID for app obtained from Apple developer account
			'private_key_path' => public_path('/ios/AuthKey_T5U8YFRV99.p8'), // Path to private key
			'private_key_secret' => null // Private key secret
		];
		}
		else if($user_type == 1)
		{
		$options = [
			'key_id' => 'T5U8YFRV99', // The Key ID obtained from Apple developer account
			'team_id' => '3J97M57G62', // The Team ID obtained from Apple developer account
			'app_bundle_id' => 'app.com.VeldooUser', // com.orem.Modo-Provider The bundle ID for app obtained from Apple developer account
			'private_key_path' => public_path('/ios/AuthKey_T5U8YFRV99.p8'), // Path to private key
			'private_key_secret' => null // Private key secret
		];
		}
		else
		{
			$options = [
			'key_id' => 'T5U8YFRV99', // The Key ID obtained from Apple developer account
			'team_id' => '3J97M57G62', // The Team ID obtained from Apple developer account
			'app_bundle_id' => 'app.com.Veldoo', // com.orem.Modo-Provider The bundle ID for app obtained from Apple developer account
			'private_key_path' => public_path('/ios/AuthKey_T5U8YFRV99.p8'), // Path to private key
			'private_key_secret' => null // Private key secret
		];
			/* $options = [
			'key_id' => 'T5U8YFRV99', // The Key ID obtained from Apple developer account
			'team_id' => '3J97M57G62', // The Team ID obtained from Apple developer account
			'app_bundle_id' => 'app.com.VeldooUser', // com.orem.Modo-Provider The bundle ID for app obtained from Apple developer account
			'private_key_path' => public_path('/ios/AuthKey_T5U8YFRV99.p8'), // Path to private key
			'private_key_secret' => null // Private key secret
		]; */
		}

		$authProvider = AuthProvider\Token::create($options);
		
		$alert = Alert::create()->setTitle($title);
		$alert = $alert->setBody($body);

		$payload = Payload::create()->setAlert($alert);

		//set notification sound to default
		$payload->setSound('example.caf');
		$additional['content_available'] = 'yes';
		$additional['mutable_content'] = 'yes';
		//add custom value to your notification, needs to be customized
		foreach($additional as $key=>$value){
		$payload->setCustomValue($key, $value);
		}

		$notifications = [];
		/* foreach ($deviceTokens as $deviceToken) {
			$notifications[] = new Notification($payload,$deviceTokens);
		} */
		// print_r($payload); die; 
		$notifications[] = new Notification($payload,$deviceTokens);
		$settings=\App\Setting::first();
		$settingValue =json_decode($settings['value']);
		$appurl_notification = $settingValue->notification;
	//echo $appurl_notification; die;
		if($appurl_notification == 1)
		{
		$client = new Client($authProvider, $production = true);
		}
		else if($appurl_notification == 0)
		{
			$client = new Client($authProvider, $production = false);
		}
		else
		{
			$client = new Client($authProvider, $production = true);
		}
		$client->addNotifications($notifications);

		$responses = $client->push();
		//print_r($responses); die;
		//echo "true";
		return $responses;
	}
	
	 function send_notification2($title='', $msg='',$token=[],$topic='', $additionalPushData=[],$isPush=true,$save=true,$platform='android',$saveData=[]){
		 
		$pushResponse = false;
		$saveResponse = '';
		if($isPush && strtolower($platform)=='android' && ($token || $topic)){
			$payload = [
				'notification' => [
					'title'=>$title,
					'body'=>$msg,
					'sound' => 'default'
				]
			 ];
			if(!empty($additionalPushData)){
				$payload['data'] = $additionalPushData;
			}
			$push = new PushNotification('fcm');
			$push->setMessage($payload);
			if(!empty($topic) && empty($token)){
				$push->sendByTopic($topic,true);
			}
			if(!empty($token) && empty($topic)){
				$push->setDevicesToken($token);
				$push->send();
			}
			$pushResponse = $push->getFeedback();
		}
		if($isPush && strtolower($platform)=='ios' && $token){
			$pushResponse  = ios_notification($title, $msg, $token,$additionalPushData);
		}
		if($save && !empty($saveData)){
			$saveData['timestamp'] = time();
			$saveResponse = \App\Notification::create($saveData)->id;
		}
		//echo $saveResponse; die;
		return ['saveResponse'=>$saveResponse,'pushResponse'=>$pushResponse];
	}
	
function helpertest()
{
	echo "test"; die;
}
  function checkPermission($permissions){
    $userAccess = getMyPermission(auth()->user()->userType);
    foreach ($permissions as $key => $value) {
      if($value == $userAccess){
        return true;
      }
    }
    return false;
  }


  function getMyPermission($id)
  {
    switch ($id) {
      case 2:
        return 'provider';
        break;
      case 3:
        return 'admin';
        break;
	  case 4:
        return 'subadmin';
        break;
      default:
        return 'user';
        break;
    }
  }
function tokenget()
{
	$length = 15;
	 $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
	return $randomString;
}
	function send_forgot_email($email_to, $message){

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->setFrom("lalitttri.orem@gmail.com", 'Foggy');
        $mail->addAddress($email_to, 'New User');
        $mail->Username = "apikey";
        $mail->Password = "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";
        $mail->Host = "smtp.sendgrid.net";
        $mail->Subject = 'Forgot Password Email';

    

        $mail->Body = $message;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->isHTML(true);

        $mail->AltBody = $message;

        if(!$mail->send()) {
            return false;
        } else {
            return true;
        }
    }
	
	function send_notification($title='', $msg1='',$token,$topic='', $additionalPushData=[],$isPush=true,$save=true,$platform='android',$saveData=[])

	{
		$ride_data = $additionalPushData['ride_data'];
		unset($ride_data['accept_time']);
		unset($ride_data['cancel_amount']);
		unset($ride_data['commission']);
		unset($ride_data['created_at']);
		unset($ride_data['cus_token']);
		unset($ride_data['driver_earning']);
		unset($ride_data['notification_send']);
		unset($ride_data['payment_id']);
		unset($ride_data['payment_by']);
		unset($ride_data['reach_time']);
		unset($ride_data['token']);
		unset($ride_data['updated_at']);
		unset($ride_data['all_drivers']);
		unset($ride_data['driver_id']);
		if(empty($ride_data['dest_address']))
		{
			$ride_data['dest_address'] = "";
		}
		if(empty($ride_data['ride_cost']))
		{
			$ride_data['ride_cost'] = "";
		}
		if(empty($ride_data['note']))
		{
			$ride_data['note'] = "";
		}
		if(empty($ride_data['alert_time']))
		{
			$ride_data['alert_time'] = "";
		}
		
		/* echo "reg id: ".$reg_id;
		echo "msg: ".$msg1;
		echo "type: ".$type;
		die; */
		//if (!defined('API_ACCESS_KEY1')) define('API_ACCESS_KEY1', 'AIzaSyD0Q9NKcD6PTu9hETOPsDMm-paR4btdIbc');

		//define('API_ACCESS_KEY1', 'AIzaSyDkMxfyaqstuhu_AhUnswDuzqqYtgkE55A');

		// prep the bundle
		if($additionalPushData['type'] == 1)
		{
		$message = array

		(

			'message' 	=> ($msg1 || $msg1 == '0')?$msg1:'',

		//	'admin_message' 	=> ($aMess)?$aMess:'',

		//	'rideID' 	=> ($rideID)?$rideID:'',

			/* 'type'=>$additionalPushData['type'],
			'userid'=>$additionalPushData['userid'],
			'sessionid'=>$additionalPushData['sessionid'],
			'opentoktoken'=>$additionalPushData['opentoktoken'],
			'image'=>$additionalPushData['image'],
			'name'=>$additionalPushData['name'], */
			'not_type'=>$additionalPushData['type'],
			'ride_id'=>$additionalPushData['ride_id'],
			'ride_data'=>json_encode($ride_data),
			//'driver_data'=>$additionalPushData['driver_data'],
			'vibrate'	    => 1,
			'title'	    => $title,

			'sound'		    => 'default'

		);
		}
		else
		{
			$message = array

		(

			'message' 	=> ($msg1 || $msg1 == '0')?$msg1:'',

		//	'admin_message' 	=> ($aMess)?$aMess:'',

		//	'rideID' 	=> ($rideID)?$rideID:'',

			/* 'type'=>$additionalPushData['type'],
			'userid'=>$additionalPushData['userid'],
			'sessionid'=>$additionalPushData['sessionid'],
			'opentoktoken'=>$additionalPushData['opentoktoken'],
			'image'=>$additionalPushData['image'],
			'name'=>$additionalPushData['name'], */
			'not_type'=>$additionalPushData['type'],
			'ride_id'=>$additionalPushData['ride_id'],
			'ride_data'=>json_encode($ride_data),
			'vibrate'	    => 1,
			'title'	    => $title,

			'sound'		    => 'default'

		);
		}

		$fields = array

		(

			'to' 	=> $token,

			'data'			=> $message,

			'priority' =>'high'

		);



		$headers = array

		(

			'Authorization: key=AAAAgHr7nhw:APA91bFIwYf7g3bGWuiPjAGK4UW52FMXP329mfx3S0097RglyBZiVbXWhVhNkt0pqF1SDHEXf4ce0P364gi2RmtuFBjwGpnT2aRLBFDfBSNE0MuNUIBcXPFBvhGhagFDSJsbiaaG91XT',

			'Content-Type: application/json'

		);
		/* $headers = array

		(

			'Authorization: key=AAAAE6XDPFc:APA91bEWpcuEyUdrpv-D6V9qZ3d1zwyYh6Bi9TgryHTdk-x8Y9HGXBeeJeGyOmkEVbGtFWcsoRUv0QO0-68YBIVGrBdN2konoeI0AZ-1ZH2IxiQuxSqycDsiYV1rJFncEUa-aHyVDDpN',

			'Content-Type: application/json'

		); */

//echo json_encode( $fields ); die;

		$ch = curl_init();

		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );

		curl_setopt( $ch,CURLOPT_POST, true );

		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );

		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );

		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );

		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );

		$result = curl_exec($ch);

		//echo "<pre>";print_r($result);die;

		curl_close( $ch );

		if ($result === FALSE) {

			die('Curl failed: ' . curl_error($ch));

		}else{

			$data=array('message'=>'success');

			//echo json_encode($data); die;

		}

		return true;

	}
	function send_iosnotification($title='', $msg1='',$token,$topic='', $additionalPushData=[],$isPush=true,$save=true,$platform='ios',$saveData=[])

	{
		//echo "true dddd";
		$ride_data = $additionalPushData['ride_data'];
		unset($ride_data['accept_time']);
		unset($ride_data['cancel_amount']);
		unset($ride_data['commission']);
		unset($ride_data['created_at']);
		unset($ride_data['cus_token']);
		unset($ride_data['driver_earning']);
		unset($ride_data['notification_send']);
		unset($ride_data['payment_id']);
		unset($ride_data['payment_by']);
		unset($ride_data['reach_time']);
		unset($ride_data['token']);
		unset($ride_data['updated_at']);
		unset($ride_data['all_drivers']);
		unset($ride_data['driver_id']);
		if(empty($ride_data['dest_address']))
		{
			$ride_data['dest_address'] = "";
		}
		if(empty($ride_data['ride_cost']))
		{
			$ride_data['ride_cost'] = "";
		}
		if(empty($ride_data['note']))
		{
			$ride_data['note'] = "";
		}
		if(empty($ride_data['alert_time']))
		{
			$ride_data['alert_time'] = "";
		}
		
		/* echo "reg id: ".$reg_id;
		echo "msg: ".$msg1;
		echo "type: ".$type;
		die; */
		//if (!defined('API_ACCESS_KEY1')) define('API_ACCESS_KEY1', 'AIzaSyD0Q9NKcD6PTu9hETOPsDMm-paR4btdIbc');

		//define('API_ACCESS_KEY1', 'AIzaSyDkMxfyaqstuhu_AhUnswDuzqqYtgkE55A');

		// prep the bundle
		
		if($additionalPushData['type'] == 1)
		{
		$message = array

		(

			'message' 	=> ($msg1 || $msg1 == '0')?$msg1:'',

			'not_type'=>$additionalPushData['type'],
			'ride_id'=>$additionalPushData['ride_id'],
			'ride_data'=>json_encode($ride_data),
			//'driver_data'=>$additionalPushData['driver_data'],
			'vibrate'	    => 1,
			'title'	    => $title,

			'sound'		    => 'default',
			'content_available' => true,
			'mutable_content' => true,

		);
		}
		else
		{
			$message = array

		(

			'message' 	=> ($msg1 || $msg1 == '0')?$msg1:'',

		//	'admin_message' 	=> ($aMess)?$aMess:'',

		//	'rideID' 	=> ($rideID)?$rideID:'',

			/* 'type'=>$additionalPushData['type'],
			'userid'=>$additionalPushData['userid'],
			'sessionid'=>$additionalPushData['sessionid'],
			'opentoktoken'=>$additionalPushData['opentoktoken'],
			'image'=>$additionalPushData['image'],
			'name'=>$additionalPushData['name'], */
			'not_type'=>$additionalPushData['type'],
			'ride_id'=>$additionalPushData['ride_id'],
			'ride_data'=>json_encode($ride_data),
			'vibrate'	    => 1,
			'title'	    => $title,

			'sound'		    => 'default',
			'content_available' => true,
			'mutable_content' => true,

		);
		}

		$fields = array

		(

			'to' 	=> $token,

			'data'			=> $message,
			'notification'			=> $message,

			'priority' =>'high'

		);



		$headers = array

		(

			'Authorization: key=AAAAgHr7nhw:APA91bFIwYf7g3bGWuiPjAGK4UW52FMXP329mfx3S0097RglyBZiVbXWhVhNkt0pqF1SDHEXf4ce0P364gi2RmtuFBjwGpnT2aRLBFDfBSNE0MuNUIBcXPFBvhGhagFDSJsbiaaG91XT',

			'Content-Type: application/json'

		);
		/* $headers = array

		(

			'Authorization: key=AAAAE6XDPFc:APA91bEWpcuEyUdrpv-D6V9qZ3d1zwyYh6Bi9TgryHTdk-x8Y9HGXBeeJeGyOmkEVbGtFWcsoRUv0QO0-68YBIVGrBdN2konoeI0AZ-1ZH2IxiQuxSqycDsiYV1rJFncEUa-aHyVDDpN',

			'Content-Type: application/json'

		); */
		//print_r($fields);
		//echo json_encode( $fields ); die;


		$ch = curl_init();

		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );

		curl_setopt( $ch,CURLOPT_POST, true );

		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );

		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );

		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );

		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
/* echo "token is: $token";
		$result = curl_exec($ch);
if($token == "e0yXRhPvRUAvp0MK6sOYwZ:APA91bEBQI82XtwbMxei4NRc0SxK3e1c_QNcpyWNrIVzTDIaWsS8b_Tn5_WEA1L67U6gescjizASvJ8bgR1v9-PO9Djut62MaMN3EwSZKVln43Mb1Y3-RoM_65DLB8olWIJix2JJMlkZ")
{
		echo "<pre>";print_r($result); die;
} */
$result = curl_exec($ch);
		curl_close( $ch );

		if ($result === FALSE) {

			die('Curl failed: ' . curl_error($ch));

		}else{

			$data=array('message'=>'success');

		//	echo json_encode($data); die;

		}
 
		return true;

	}
	 function send_inotification_p8($reg_id,$msg1) {
		
		$keyfile = ROOT."/app/webroot/AuthKey_4826WJKA47.p8";               # <- Your AuthKey file
  $keyid = '4826WJKA47';                            # <- Your Key ID
  $teamid = '957KU368LT';                           # <- Your Team ID (see Developer Portal)
  $bundleid = 'com.orem.Delivery-Expert';                # <- Your Bundle ID
  $url = 'https://api.push.apple.com';  # <- development url, or use http://api.push.apple.com for production environment
  $token = $reg_id;              # <- Device Token

	//$sendDataJson = json_encode($body);
  //$message = '{"aps":{"alert":"Hi there!","sound":"default"}}';
  
  $body['aps'] = array(

		'alert' => ($msg1 || $msg1 == '0')?$msg1:'',

		'message' 	=>($msg1 || $msg1 == '0')?$msg1:'',
	//	'rideID' 	=> ($rideID)?$rideID:'',

		'sound' => 'default',

		'badge' => 0,

		//'message'=>$message

	);
	
		
		$sendDataJson = json_encode($body);

  $key = openssl_pkey_get_private('file://'.$keyfile);

  $header = ['alg'=>'ES256','kid'=>$keyid];
  $claims = ['iss'=>$teamid,'iat'=>time()];

  $header_encoded = $this->base64($header);
  $claims_encoded = $this->base64($claims);

  $signature = '';
  openssl_sign($header_encoded . '.' . $claims_encoded, $signature, $key, 'sha256');
  $jwt = $header_encoded . '.' . $claims_encoded . '.' . base64_encode($signature);

  // only needed for PHP prior to 5.5.24
  if (!defined('CURL_HTTP_VERSION_2_0')) {
      define('CURL_HTTP_VERSION_2_0', 3);
  }

  $http2ch = curl_init();
  curl_setopt_array($http2ch, array(
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
    CURLOPT_URL => "$url/3/device/$token",
    CURLOPT_PORT => 443,
    CURLOPT_HTTPHEADER => array(
      "apns-topic: {$bundleid}",
      "authorization: bearer $jwt"
    ),
    CURLOPT_POST => TRUE,
    CURLOPT_POSTFIELDS => $sendDataJson,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HEADER => 1
  ));

  $result = curl_exec($http2ch);
  if ($result === FALSE) {
    //throw new Exception("Curl failed: ".curl_error($http2ch));
	return 0;
  }

  $status = curl_getinfo($http2ch, CURLINFO_HTTP_CODE);
  if($status == 200)
  {
	  return 1;
  }
  else{
	  return 0;
  }
		
		
		
		

	}
	
	function base64($data) {
    return rtrim(strtr(base64_encode(json_encode($data)), '+/', '-_'), '=');
  }

function bulk_pushok_ios_notification($title, $body, $deviceTokens, $additional = array(), $sound = 'default', $user_type)
{
	if ($user_type == 2) {
		$options = [
			'key_id' => env('IOS_KEY_ID'), // The Key ID obtained from Apple developer account
			'team_id' => env('IOS_TEAM_ID'), // The Team ID obtained from Apple developer account
			'app_bundle_id' => env('IOS_APP_BUNDLE_ID_DRIVER'), // com.orem.Modo-Provider The bundle ID for app obtained from Apple developer account
			'private_key_path' => public_path('/ios/AuthKey_T5U8YFRV99.p8'), // Path to private key
			'private_key_secret' => null // Private key secret
		];
	} else if ($user_type == 1) {
		$options = [
			'key_id' => env('IOS_KEY_ID'), // The Key ID obtained from Apple developer account
			'team_id' => env('IOS_TEAM_ID'), // The Team ID obtained from Apple developer account
			'app_bundle_id' => env('IOS_APP_BUNDLE_ID_USER'), // com.orem.Modo-Provider The bundle ID for app obtained from Apple developer account
			'private_key_path' => public_path('/ios/AuthKey_T5U8YFRV99.p8'), // Path to private key
			'private_key_secret' => null // Private key secret
		];
	} else {
		$options = [
			'key_id' => env('IOS_KEY_ID'), // The Key ID obtained from Apple developer account
			'team_id' => env('IOS_TEAM_ID'), // The Team ID obtained from Apple developer account
			'app_bundle_id' => env('IOS_APP_BUNDLE_ID_DRIVER'), // com.orem.Modo-Provider The bundle ID for app obtained from Apple developer account
			'private_key_path' => public_path('/ios/AuthKey_T5U8YFRV99.p8'), // Path to private key
			'private_key_secret' => null // Private key secret
		];
	}

	$authProvider = AuthProvider\Token::create($options);

	$alert = Alert::create()->setTitle($title);
	$alert = $alert->setBody($body);

	$payload = Payload::create()->setAlert($alert);

	//set notification sound to default
	$payload->setSound('example.caf');
	// $payload->setContentAvailability(true);
	// $payload->setMutableContent(true);
	//add custom value to your notification, needs to be customized
	foreach ($additional as $key => $value) {
		$payload->setCustomValue($key, $value);
	}

	$notifications = [];
	foreach ($deviceTokens as $deviceToken) {
		$notifications[] = new Notification($payload, $deviceToken);
	}
	$settings = \App\Setting::first();
	$settingValue = json_decode($settings['value']);
	$appurl_notification = $settingValue->notification;
	if ($appurl_notification == 1) {
		$client = new Client($authProvider, $production = true);
	} else if ($appurl_notification == 0) {
		$client = new Client($authProvider, $production = false);
	} else {
		$client = new Client($authProvider, $production = true);
	}
	$client->addNotifications($notifications);

	$responses = $client->push();
	return $responses;
}

function bulk_firebase_android_notification($title = '', $msg = '', $token, $additionalPushData = [])
{
	if(!empty($additionalPushData['ride_data'])){
		$ride_data = $additionalPushData['ride_data'];
		unset($ride_data['accept_time']);
		unset($ride_data['cancel_amount']);
		unset($ride_data['commission']);
		unset($ride_data['created_at']);
		unset($ride_data['cus_token']);
		unset($ride_data['driver_earning']);
		unset($ride_data['notification_send']);
		unset($ride_data['payment_id']);
		unset($ride_data['payment_by']);
		unset($ride_data['reach_time']);
		unset($ride_data['token']);
		unset($ride_data['updated_at']);
		unset($ride_data['all_drivers']);
		unset($ride_data['driver_id']);
		if (empty($ride_data['dest_address'])) {
			$ride_data['dest_address'] = "";
		}
		if (empty($ride_data['ride_cost'])) {
			$ride_data['ride_cost'] = "";
		}
		if (empty($ride_data['note'])) {
			$ride_data['note'] = "";
		}
		if (empty($ride_data['alert_time'])) {
			$ride_data['alert_time'] = "";
		}
		// prep the bundle
		$message = array(
			'message' 	=> (!empty($msg))?$msg:"",
			'not_type' => $additionalPushData['type'],
			'ride_id' => $additionalPushData['ride_id'],
			'ride_data' => json_encode($ride_data),
			'vibrate'	    => 1,
			'title'	    => $title,
			'sound'		    => 'default'
		);
	} else {
		$message = array(
			'title' => $title,
			'message' => (!empty($msg))?$msg:"",
			'not_type' => $additionalPushData['type'],
			'vibrate' => 1,
			'sound'	=> 'default'
		);
	}
	
	$fields = array(
		'registration_ids' => $token,
		'data' => $message,
		'priority' => 'high'
	);

	$headers = array(
		'Authorization: key=AAAAgHr7nhw:APA91bFIwYf7g3bGWuiPjAGK4UW52FMXP329mfx3S0097RglyBZiVbXWhVhNkt0pqF1SDHEXf4ce0P364gi2RmtuFBjwGpnT2aRLBFDfBSNE0MuNUIBcXPFBvhGhagFDSJsbiaaG91XT',
		'Content-Type: application/json'
	);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	$result = curl_exec($ch);
	curl_close($ch);
	// DB::table('test_jobs')->insert(['data'=>json_encode($result)]);
	if ($result === FALSE) {
		die('Curl failed: ' . curl_error($ch));
	} else {
		// DB::table('test_jobs')->insert(['data'=>'success']);
		$data = array('message' => 'success');
	}
	return true;
}

function sortByDistance($x, $y) {
    return $x['distance'] - $y['distance'];
}

?>