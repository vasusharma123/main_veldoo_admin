<?php
namespace App\Helpers;
use Pushok\AuthProvider;
use Pushok\Client;
use Pushok\Notification;
use Pushok\Payload;
use Pushok\Payload\Alert;
use App\UserMeta;
use Edujugon\PushNotification\PushNotification;
class Helper
{
    public static function ios_notification($title, $body, $deviceTokens = array(), $additional=array(), $sound='default')
	{
		$options = [
			'key_id' => 'CF4VRJ5MTX', // The Key ID obtained from Apple developer account
			'team_id' => 'F59582WJ98', // The Team ID obtained from Apple developer account
			'app_bundle_id' => 'com.orem.zfoodChef', // com.orem.Modo-Provider The bundle ID for app obtained from Apple developer account
			'private_key_path' => public_path('/ios/private_key.p8'), // Path to private key
			'private_key_secret' => null // Private key secret
		];

		$authProvider = AuthProvider\Token::create($options);
		
		$alert = Alert::create()->setTitle($title);
		$alert = $alert->setBody($body);

		$payload = Payload::create()->setAlert($alert);

		//set notification sound to default
		$payload->setSound($sound);

		//add custom value to your notification, needs to be customized
		foreach($additional as $key=>$value){
		$payload->setCustomValue($key, $value);
		}

		$notifications = [];
		foreach ($deviceTokens as $deviceToken) {
			$notifications[] = new Notification($payload,$deviceToken);
		}

		$client = new Client($authProvider, $production = false);
		$client->addNotifications($notifications);

		$responses = $client->push();
		return $responses;
	}
    
	public static function send_notification2($title='', $msg='',$token=[],$topic='', $additionalPushData=[],$isPush=true,$save=true,$platform='android',$saveData=[]){
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
			$pushResponse  = self::ios_notification($title, $msg, $token,$additionalPushData);
		}
		if($save && !empty($saveData)){
			$saveData['timestamp'] = time();
			$saveResponse = \App\Notification::create($saveData)->id;
		}
		return ['saveResponse'=>$saveResponse,'pushResponse'=>$pushResponse];
	}
	function send_notification($title='', $msg1='',$token,$topic='', $additionalPushData=[],$isPush=true,$save=true,$platform='android',$saveData=[])

	{
		/* echo "reg id: ".$reg_id;
		echo "msg: ".$msg1;
		echo "type: ".$type;
		die; */
		//if (!defined('API_ACCESS_KEY1')) define('API_ACCESS_KEY1', 'AIzaSyD0Q9NKcD6PTu9hETOPsDMm-paR4btdIbc');

		//define('API_ACCESS_KEY1', 'AIzaSyDkMxfyaqstuhu_AhUnswDuzqqYtgkE55A');

		// prep the bundle

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
			
			'vibrate'	    => 1,

			'sound'		    => 'default'

		);

		$fields = array

		(

			'to' 	=> $token,

			'data'			=> $message,

			'priority' =>'high'

		);



		$headers = array

		(

			'Authorization: key=AAAApFrBj_0:APA91bGVLz7zJnGqLmTwgEl0Y6Scqdf2VU6Nk_s33Z7fqGrX9dpsazXbLPr1ITSO364ey91aIcg1Vac8omjQ7geChJij5CQUe-AjZS5Mg5yrB-5O5jmXf3Kl_kXzToixkxSMU_n4_2xe',

			'Content-Type: application/json'

		);
		/* $headers = array

		(

			'Authorization: key=AAAAE6XDPFc:APA91bEWpcuEyUdrpv-D6V9qZ3d1zwyYh6Bi9TgryHTdk-x8Y9HGXBeeJeGyOmkEVbGtFWcsoRUv0QO0-68YBIVGrBdN2konoeI0AZ-1ZH2IxiQuxSqycDsiYV1rJFncEUa-aHyVDDpN',

			'Content-Type: application/json'

		); */



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

			echo json_encode($data); die;

		}

		return true;

	}
	public static function shout(string $string)
    {
        return strtoupper($string);
    }
	
	public static function clean(string $string) {
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		$string = str_replace('_', '-', $string); // Replaces all spaces with hyphens.
		$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
		$string = strtolower($string); // Convert to lowercase
 
		return $string;
	}

	public static function totalAdminFreeSubscribed()
	{
		return UserMeta::where([
			['meta_key','=','_admin_free_subscription_days'],
			['meta_value','>',0]
		])->count();
	}
}
?>