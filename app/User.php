<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Image;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, Notifiable, HasMediaTrait,  \Spatie\Tags\HasTags,HasRoles,SoftDeletes;

    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'name', 'first_name', 'last_name', 'email', 'image', 'location', 'lat', 'lng', 'user_type', 'status', 'zip', 'addresses', 'password', 'verify', 'device_type', 'device_token', 'fcm_token', 'state', 'country_code', 'phone', 'city', 'availability', 'country', 'step', 'earned_points', 'spent_points', 'created_by', 'street', 'second_country_code', 'second_phone_number'
	];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	// protected $appends = [
	// 	'full_name','avg_rating','car_data','phone_number','country_code','country','state','city','zip','addresses'
	// ];

	protected $appends = [
		'user_role'
	];
	
	public function setPasswordAttribute($password){
		 
		 
		if (!empty($password)) {

			// check if the value is already a hash (Regex: String begins with '$2y$##$' followed by at least 50 characters)
			if ( preg_match('/^\$2y\$[0-9]*\$.{50,}$/', $password) ) {
				// if it is so, set the attribute without hashing again
				$this->attributes['password'] = $password;
			}
			else {
				// else hash the password and set as attribute
				$this->attributes['password'] = bcrypt($password);
			}
			
			return true;
		}
		
		return false;
       // $this->attributes['password'] = bcrypt($password);
    }
	
    public function setUserNameAttribute($value)
    {
        $this->attributes['user_name'] = $value;
    }
	
	public function AauthAcessToken(){
		return $this->hasMany('\App\OauthAccessToken');
	}

	public function findForPassport($identifier) {
	   return User::orWhere('email', $identifier)->first();
	}

	public function scopeOfSearch($query, $q)
	{
		if ( $q ) {
			$query->where('name', 'LIKE', '%' . $q . '%')
				  ->orWhere('last_name', 'LIKE', '%' . $q . '%')
				  ->orWhere('first_name', 'LIKE', '%' . $q . '%');
		}

		return $query;
	}

	public function scopeOfSort($query, $sort = [])
	{
		if ( ! empty($sort) ) {
			foreach ( $sort as $column => $direction ) {
				$query->orderBy($column, $direction);
			}
		} 
		else {
			$query->orderBy('id'); 
		}

		return $query;
	}


    public function getFullNameAttribute()
	{
		return $this->first_name.' '.$this->last_name;
	}
	
    
    public function category()
    {
		return $this->hasMany(UserCategory::class,'user_id','id')->with('parent_cat:id,name');
    }
	
	public function user_meta()
    {
        return $this->hasMany('\App\UserMeta');
    }
	
	public static function boot()
	{
       parent::boot();
       static::deleted(function($model)
       {
			Storage::disk('public')->deleteDirectory("user/{$model->id}");
       });       
	}
	public function resize($id, $image,$extension){
		$conversionPath = [];
		$dir = "user/$id/conversion";
		// $extension = $image->getClientOriginalExtension();
		$conversions = ['thumb'=>['w'=>100,'h'=>100],'small'=>['w'=>300,'h'=>300], 'medium'=>['w'=>200,'h'=>200]];
		
		foreach($conversions as $s=>$c){
			$path1 = "$dir/{$c['w']}x{$c['h']}-aspect-$s.".$extension;
			$path2 = "$dir/{$c['w']}x{$c['h']}-resize-$s.".$extension;
			$path3 = "$dir/{$c['w']}x{$c['h']}-fit-$s.".$extension;
			if(Storage::disk('public')->put($path1, Image::make($image)->resize($c['w'], $c['h'], function ($co) { $co->aspectRatio(); })->stream()->__toString())){ $conversionPath["{$c['w']}x{$c['h']}-aspect-$s"] = $path1; }
			if(Storage::disk('public')->put($path2, Image::make($image)->resize($c['w'], $c['h'])->stream()->__toString())){ $conversionPath["{$c['w']}x{$c['h']}-resize-$s"] = $path2; }
			if(Storage::disk('public')->put($path3, Image::make($image)->fit($c['w'], $c['h'])->stream()->__toString())){ $conversionPath["{$c['w']}x{$c['h']}-fit-$s"] = $path3; }
		}
		return $conversionPath;
	}
	
	function driverVehicle(){
		return $this->hasOne(Vehicle::class,'user_id','id');
	}
	public function getAvgRatingAttribute()
	{
		$avgrating = DB::table('ratings')->where('to_id', $this->id)->avg('rating');
				return $avgrating = round($avgrating,2);
				//$driver_data->avg_rating = "$avgrating";
		//return $this->first_name.' '.$this->last_name;
	}

	public static function logoutUserByIdAllDevices($id)
	{
		$updateUser = self::where('id', $id)->first();
		// print_r($id);die;
		$updateUser->tokens()->delete();
		self::where(['id' => $id])->update(['availability' => 0]);
		return true;
	}
	
   /**
     * Created By Anil Dogra
     * Created At 12-03-2021
     * @param NULL
     * @return Array of update user
     */
   public function updateUser($id, $inputArr){
   	
               return self::where('id', $id)->update($inputArr);
        }    
	public function getCarDataAttribute()
	{
		$driver_car = DriverChooseCar::where('user_id', $this->id)->orderBy('id','desc')->first();
		if(!empty($driver_car )){
			$car_data = Vehicle::select('id','model','vehicle_image','vehicle_number_plate')->where('id', $driver_car['car_id'])->first();
if(!empty($car_data)){
	return $car_data;
}else{
	return null;
}
		}else{
			return null;
		}
	}

	/**
     * Created By Anil Dogra
     * Created At 12-03-2021
     * @param NULL
     * @return Array of logoutUserByIdAllDevices
     */

   public function getDriverList(){
   	 return self::where('user_type',4)->orderBy('id','DESC')->get();
   }
   /**
     * Created By Anil Dogra
     * Created At 12-03-2021
     * @param NULL
     * @return Array of logoutUserByIdAllDevices
     */

    public function getCompanyResponseArr(){

          $returnArr = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'country_code' =>(int)$this->country_code,
            'phone' => $this->phone,
            'image' => ($this->image) ? url('storage/app/public/'.$this->image) : ('null'),
            'latitude' => $this->current_lat,
            'longitude' => $this->current_lng,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'street' => $this->addresses,
            'zip_code' => $this->zip,
            'status'=>($this->status==1)?'Active':'Inactive',
			'user_type'=>$this->user_type,
			'created_at'=>$this->created_at,
			'updated_at'=>$this->updated_at,
           
            	
        ];
        return $returnArr;
    }

     /**
     * Created By Anil Dogra
     * Created At 12-03-2021
     * @param NULL
     * @return Array of upload image
     */
	 public function uploadImage($image,$id)
    {
		 $destinationPath= \Storage::disk()->path('public/user/'.$id);
         File::deleteDirectory($destinationPath);  		 
		$path='public/user/'.$id;
		if(!Storage::exists($path)){
			Storage::makeDirectory($path);
		}
            
        $fileName   = time() . '.' . $image->getClientOriginalExtension();            
        Storage::disk('profile_pic')->putFileAs('/user/', $image, $id.'/'.$fileName);
        return $fileName;
    }
	// public function getPhoneNumberAttribute()
	// {
	// 	$user_data = UserData::where('user_id', $this->id)->orderBy('id','desc')->first();
	// 	  if(!empty($user_data))
	// 	  {
	// 	return $user_data['phone_number'];
	// 	  }
	// 	  else
	// 	  {
	// 		  return null;
	// 	  }
	// }
	// public function getCountryCodeAttribute()
	// {
	// 	$user_data = UserData::where('user_id', $this->id)->orderBy('id','desc')->first();
	// 	  if(!empty($user_data))
	// 	  {
	// 	return $user_data['country_code'];
	// 	  }
	// 	  else
	// 	  {
	// 		  return null;
	// 	  }
	// }
	// public function getCountryAttribute()
	// {
	// 	$user_data = UserData::where('user_id', $this->id)->orderBy('id','desc')->first();
	// 	  if(!empty($user_data))
	// 	  {
	// 	return $user_data['country'];
	// 	  }
	// 	  else
	// 	  {
	// 		  return null;
	// 	  }
	// }
	// public function getStateAttribute()
	// {
	// 	$user_data = UserData::where('user_id', $this->id)->orderBy('id','desc')->first();
	// 	  if(!empty($user_data))
	// 	  {
	// 	return $user_data['state'];
	// 	  }
	// 	  else
	// 	  {
	// 		  return null;
	// 	  }
	// }
	// public function getCityAttribute()
	// {
	// 	$user_data = UserData::where('user_id', $this->id)->orderBy('id','desc')->first();
	// 	  if(!empty($user_data))
	// 	  {
	// 	return $user_data['city'];
	// 	  }
	// 	  else
	// 	  {
	// 		  return null;
	// 	  }
	// }
	// public function getZipAttribute()
	// {
	// 	$user_data = UserData::where('user_id', $this->id)->orderBy('id','desc')->first();
	// 	  if(!empty($user_data))
	// 	  {
	// 	return $user_data['zip'];
	// 	  }
	// 	  else
	// 	  {
	// 		  return null;
	// 	  }
	// }
	// public function getAddressesAttribute()
	// {
	// 	$user_data = UserData::where('user_id', $this->id)->orderBy('id','desc')->first();
	// 	  if(!empty($user_data))
	// 	  {
	// 	return $user_data['addresses'];
	// 	  }
	// 	  else
	// 	  {
	// 		  return null;
	// 	  }
	// }
	// public function user_data(){
	// 	return $this->hasOne(UserData::class,'user_id','id');
	// 	}

	function ride()
	{
		return $this->hasOne(Ride::class, 'driver_id', 'id');
	}

	public function getUserRoleAttribute()
	{
		$user_types= [1=>"customer",2=>"driver",3=>"admin",4=>"company"];
		return $user_types[$this->user_type];
	}
}
