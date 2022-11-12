<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Stopover;
use App\User;
use App\Vehicle;
use Exception;
use Twilio\Rest\Client;

class Ride extends Model
{

	protected $fillable = ['id', 'pickup_address', 'dest_address', 'ride_type', 'user_id', 'driver_id', 'schedule_time', 'company_id', 'payment_by', 'alert_time', 'payment_type', 'car_type', 'passanger', 'note', 'additional_note', 'ride_time', 'ride_cost', 'distance', 'alert_notification_date_time'];

	protected $appends = [
		'stop_over',
	];

	public function user()
	{
		return $this->hasOne(User::class, 'id', 'user_id');
	}
	public function driver()
	{
		return $this->hasOne('App\User', 'id', 'driver_id');
	}

	public function category()
	{
		return $this->hasOne(Category::class, 'id', 'car_type');
	}

	public function carType()
	{
		return $this->hasOne(Price::class, 'id', 'car_type');
	}

	public function users()
	{
		return $this->belongsTo(User::class, 'id', 'user_id');
	}
	public function getStopOverAttribute()
	{
		return $stopovers = DB::table('stopovers')->where('ride_id', $this->id)->get()->toArray();
		// return $avgrating = round($avgrating,2);
		//$driver_data->avg_rating = '$avgrating';
		//return $this->first_name.' '.$this->last_name;
	}

	public function getCarData($id)
	{
		$driver_car = DriverChooseCar::where('user_id', $id)->orderBy('id', 'desc')->first();
		if (!empty($driver_car)) {
			$car_data = Vehicle::select('id', 'model', 'vehicle_image', 'vehicle_number_plate')->where('id', $driver_car['car_id'])->first();
			if (!empty($car_data)) {
				return $car_data;
			} else {
				return null;
			}
		} else {
			return null;
		}
	}
	public function getAvgRating($id)
	{
		$avgrating = DB::table('ratings')->where('to_id', $id)->avg('rating');
		return $avgrating = round($avgrating, 2);
		//$driver_data->avg_rating = '$avgrating';
		//return $this->first_name.' '.$this->last_name;
	}

	public static function getRideDriverList($rideId)
	{
		$result = self::where('id', $rideId)->pluck('all_drivers')->first();
		return ($result) ? explode(',', $result) : array();
	}

	public function getRideHistory($users, $inputArr)
	{
		$query = null;
		if ($users->user_type == 1) {
			$query = self::where('user_id', $users->id);
			if ($inputArr['type'] == 1) {
				$query->whereIn('status', [0, 1, 2, 4, -4]);
			}
			if ($inputArr['type'] == 2) {
				$query->whereIn('status', [3]);
			}
			if ($inputArr['type'] == 3) {
				$query->whereIn('status', [-2]);
			}
		} else if ($users->user_type == 2) {
			if ($users->is_master == 1) {
				if ($inputArr['type'] == 1) {
					$query = self::whereIn('status', [0, 1, 2, 4, -4]);
				}
				if ($inputArr['type'] == 2) {
					$query = self::whereIn('status', [3]);
				}
				if ($inputArr['type'] == 3) {
					$query = self::whereIn('status', [-2]);
				}
			} else {
				$query = self::where('user_id', $users->id);
				if ($inputArr['type'] == 1) {
					$query->whereIn('status', [0, 1, 2, 4, -4]);
				}
				if ($inputArr['type'] == 2) {
					$query->whereIn('status', [3]);
				}
				if ($inputArr['type'] == 3) {
					$query->whereIn('status', [-2]);
				}
			}
		}


		$queryData = $query->offset($inputArr['page_index'])->limit($inputArr['limit'])->orderBy('id', 'DESC')->get();

		return $queryData;
	}

	public function getRideList()
	{

		if (!empty($this->driver_id) && !is_null($this->driver)) {
			$driver = User::where('id', $this->driver_id)->first();
			$driver['car_data'] = self::getCarData($this->driver_id);
			$driver['avg_rating'] = self::getAvgRating($this->driver_id);
		} else {
			$driver = null;
		}
		$returnArr = [
			'id' => $this->id,
			'user_id' => $this->user_id,
			'driver_id' => $this->driver_id,
			'all_drivers' => $this->all_drivers,
			'company_id' => $this->company_id,
			'schedule_ride' => $this->schedule_ride,
			'schedule_time' => $this->schedule_time,
			'pick_lat' => $this->pick_lat,
			'pick_lng' => $this->pick_lng,
			'dest_lat' => $this->dest_lat,
			'dest_lng' => $this->dest_lng,
			'pickup_address' => $this->pickup_address,
			'dest_address' => $this->dest_address,
			'price' => $this->price,
			'car_type' => $this->car_type,
			'payment_type' => $this->payment_type,
			'payment_id' => $this->payment_id,
			'cus_token' => $this->cus_token,
			'token' => $this->token,
			'status' => $this->status,
			'distance' => $this->distance,
			'duration' => $this->duration,
			'notification_send' => $this->notification_send,
			'pool_ride' => $this->pool_ride,
			'ride_time' => $this->ride_time,
			'accept_time' => $this->accept_time,
			'reach_time' => $this->reach_time,
			'cancel_reason' => $this->cancel_reason,
			'cancel_amount' => $this->cancel_amount,
			'pool_number' => $this->pool_number,
			'commission' => $this->commission,
			'driver_earning' => $this->driver_earning,
			'ride_type' => $this->ride_type,
			'payment_by' => $this->payment_by,
			'passanger' => $this->passanger,
			'alert_time' => $this->alert_time,
			'note' => $this->note,
			'ride_cost' => $this->ride_cost,
			'created_by' => $this->created_by,
			'notification_sent' => $this->notification_sent,
			'alert_send' => $this->alert_send,
			'waiting' => $this->waiting,
			'join_id' => $this->join_id,
			'max_seats' => $this->max_seats,
			'actual_share_ride' => $this->actual_share_ride,
			'miles_received' => $this->miles_received,
			'request_time' => $this->request_time,
			'promotion_id' => $this->promotion_id,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
			'stop_over' => Stopover::where('ride_id', $this->id)->get(),
			'user' => User::where('id', $this->user_id)->first(),
			'driver' => $driver
		];

		return $returnArr;
	}

	public function vehicle()
	{
		return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
	}

	public function company()
	{
		return $this->belongsTo(User::class, 'company_id', 'id');
	}

	public function company_data()
	{
		return $this->belongsTo(User::class, 'company_id', 'id');
	}

	public function accept_ride_sms_notify($user, $choosed_vehicle)
	{
		try {
			$sid = env("TWILIO_ACCOUNT_SID");
			$token = env("TWILIO_AUTH_TOKEN");
			$twilio = new Client($sid, $token);

			$twilio->messages
			->create(
				"+".$user->country_code.$user->phone, // to
				[
					"body" => "Your driver is on the way to pick you up on - ".$choosed_vehicle->vehicle->model.", ".$choosed_vehicle->vehicle->vehicle_number_plate,
					"from" => env("TWILIO_FROM_SEND")
				]
			);
		} catch (\Exception $exception) {
			return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
		}
	}

	public function driver_reach_sms_notify($user)
	{
		try {
			$sid = env("TWILIO_ACCOUNT_SID");
			$token = env("TWILIO_AUTH_TOKEN");
			$twilio = new Client($sid, $token);

			$twilio->messages
			->create(
				"+$user->country_code.$user->phone", // to
				[
					"body" => "Your driver is here to pick you up",
					"from" => env("TWILIO_FROM_SEND")
				]
			);
		} catch (\Exception $exception) {
			return response()->json(['status' => 0, 'message' => $exception->getMessage()]);
		}
	}
}
