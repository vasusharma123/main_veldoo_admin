<?php

namespace App\Http\Controllers;

use App\User;
use App\Price;
use App\Vehicle;
use App\Setting;
use App\SMSTemplate;
use App\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;


class ServiceProviderController extends Controller
{

    public function serviceProviderVerify($token)
    {
        $verifyUser = User::where('is_email_verified_token', $token)->first();
        if (!is_null($verifyUser)) {
            $password = Str::random(8);
            $verifyUser->is_email_verified = 1;
            // $verifyUser->is_email_verified_token = "";
            // $verifyUser->password = Hash::make($password);
            $verifyUser->update();

            // $driver = new User();
            // $driver->fill([
            // 	'email' => 'driver_' . $verifyUser->email,
            // 	'first_name' => $verifyUser->first_name,
            // 	'last_name' => $verifyUser->last_name,
            // 	'country_code' => $verifyUser->country_code,
            // 	'phone' => $verifyUser->phone,
            // 	'is_master' => 1,
            // 	'user_type' => 2,
            // 	'password' => Hash::make($password),
            // 	'service_provider_id' => $verifyUser->id,
            // ]);
            // $driver->save();
            // $serviceProviderDriver = new ServiceProviderDriver();
            // $serviceProviderDriver->fill(['service_provider_id' => $verifyUser->id, 'driver_id' => $driver->id]);
            // $serviceProviderDriver->save();
            //customer
            // $user = new User();
            // $user->fill([
            // 	'email' => 'user_' . $verifyUser->email,
            // 	'first_name' => $verifyUser->first_name,
            // 	'last_name' => $verifyUser->last_name,
            // 	'country_code' => $verifyUser->country_code,
            // 	'phone' => $verifyUser->phone,
            // 	'user_type' => 1,
            // 	'verify' => 1,
            // 	'password' => Hash::make($password),
            // 	'service_provider_id' => $verifyUser->id,
            // ]);
            // $user->save();

            $settingValue = [
                "admin_logo" => "",
                "radius" => "50",
                "site_name" => $verifyUser->name,
                "first_x_free_users" => "1",
                "admin_free_subscription_days" => "1",
                "copyright" => $verifyUser->name,
                "admin_primary_color" => "#fc4c02",
                "ad_interval" => "2",
                "topic_title_limit" => "2",
                "admin_background" => "",
                "admin_favicon" => "",
                "admin_sidebar_logo" => "",
                "_token" => "",
                "facebook_link" => "",
                "twitter_link" => "",
                "instagram_link" => "",
                "paypal_email" => "",
                "admin_commission" => "21",
                "base_delivery_price" => "21",
                "base_delivery_distance" => "21",
                "tax" => "21",
                "credit_card_fee" => "21",
                "stripe_mode" => "",
                "stripe_test_secret_key" => "",
                "stripe_test_publish_key" => "",
                "ride_type" => "1",
                "pickup_address" => "sec 10 chandigarh",
                "dest_address" => "sec 12 chandigarh",
                "additional_notes" => "test",
                "notification" => 0,
                "number_of_drivers_get_notification" => "1",
                "currency_symbol" => "CHF",
                "currency_name" => "Franken",
                "interval_time" => "1",
                "driver_requests" => "3",
                "waiting_time" => "30",
                "pickup_distance" => "1",
                "join_radius" => "5",
                "first_request_send" => "2",
                "driver_idle_time" => "60",
                "current_ride_distance_addition" => "10",
                "waiting_ride_distance_addition" => "15"
            ];
            $setting = new Setting();
            $setting->fill(['key' => '_configuration', 'service_provider_id' => $verifyUser->id, 'value' => json_encode($settingValue)]);
            $setting->save();

            //vehicle-type
            $vehicleType = new Price();
            $vehicleType->fill([
                'car_type' => 'Regular Car',
                'price_per_km' => '3.6',
                'basic_fee' => '6',
                'seating_capacity' => '4',
                'alert_time' => '15',
                'status' => '1',
                'sort' => '0',
                'service_provider_id' => $verifyUser->id,
            ]);
            $vehicleType->save();

            //vehicle
            $vehicle = new Vehicle();
            $vehicle->fill([
                'category_id' => $vehicleType->id,
                'year' => date('Y'),
                'model' => Str::random(10),
                'vehicle_number_plate' => Str::random(6),
                'service_provider_id' => $verifyUser->id,
            ]);
            $vehicle->save();
            $vehicle = new Vehicle();
            $vehicle->fill([
                'category_id' => $vehicleType->id,
                'year' => date('Y'),
                'model' => Str::random(10),
                'vehicle_number_plate' => Str::random(6),
                'service_provider_id' => $verifyUser->id,
            ]);
            $vehicle->save();

            //vehicle-type
            $vehicleType = new Price();
            $vehicleType->fill([
                'car_type' => 'Business Car',
                'price_per_km' => '3.6',
                'basic_fee' => '6',
                'seating_capacity' => '4',
                'alert_time' => '15',
                'status' => '1',
                'sort' => '0',
                'service_provider_id' => $verifyUser->id,
            ]);
            $vehicleType->save();

            //vehicle
            $vehicle = new Vehicle();
            $vehicle->fill([
                'category_id' => $vehicleType->id,
                'year' => date('Y'),
                'model' => Str::random(10),
                'vehicle_number_plate' => Str::random(6),
                'service_provider_id' => $verifyUser->id,
            ]);
            $vehicle->save();

            // SMS templates
            SMSTemplate::insert([
                [
                    "title" => "Send OTP (create booking)",
                    "english_content" => "Dear User, your Veldoo verification code is #OTP#. Use this password to complete your booking",
                    "german_content" => "Sehr geehrter Benutzer, Ihr Veldoo-Bestätigungscode lautet #OTP#. Verwenden Sie dieses Passwort, um Ihre Buchung abzuschließen",
                    "service_provider_id" => $verifyUser->id,
                    "unique_key" => "send_otp_create_booking",
                ],
                [
                    "title" => "Send booking details after create booking",
                    "english_content" => "Your Booking has been confirmed with Veldoo, for time - #TIME#. To view the status of your ride go to: #LINK#",
                    "german_content" => "Ihre Buchung wurde mit Veldoo für die Zeit bestätigt - #TIME#. Um den Status Ihrer Fahrt anzuzeigen, gehen Sie zu: #LINK#",
                    "service_provider_id" => $verifyUser->id,
                    "unique_key" => "send_booking_details_after_create_booking",
                ],
                [
                    "title" => "Send OTP for my bookings",
                    "english_content" => "Dear User, your Veldoo verification code is #OTP#",
                    "german_content" => "Sehr geehrter Benutzer, Ihr Veldoo-Bestätigungscode lautet #OTP#",
                    "service_provider_id" => $verifyUser->id,
                    "unique_key" => "send_otp_for_my_bookings",
                ],
                [
                    "title" => "Send OTP before ride edit",
                    "english_content" => "Dear User, your Veldoo verification code is #OTP#. Use this password to complete your booking",
                    "german_content" => "Sehr geehrter Benutzer, Ihr Veldoo-Bestätigungscode lautet #OTP#. Verwenden Sie dieses Passwort, um Ihre Buchung abzuschließen",
                    "service_provider_id" => $verifyUser->id,
                    "unique_key" => "send_otp_before_ride_edit",
                ],
                [
                    "title" => "Send booking details after edit booking",
                    "english_content" => "Your Booking has been confirmed with Veldoo, for time - #TIME#. To view the status of your ride go to: #LINK#",
                    "german_content" => "Ihre Buchung wurde mit Veldoo für die Zeit bestätigt - #TIME#. Um den Status Ihrer Fahrt anzuzeigen, gehen Sie zu: #LINK#",
                    "service_provider_id" => $verifyUser->id,
                    "unique_key" => "send_booking_details_after_edit_booking",
                ],
                [
                    "title" => "Ride Accepted By driver",
                    "english_content" => "Ride Accepted By driver",
                    "german_content" => "Fahrt vom Fahrer akzeptiert",
                    "service_provider_id" => $verifyUser->id,
                    "unique_key" => "ride_accepted_by_driver",
                ],
                [
                    "title" => "Driver reached to pickup point",
                    "english_content" => "Driver reached to pickup point",
                    "german_content" => "Der Fahrer erreichte den Abholpunkt",
                    "service_provider_id" => $verifyUser->id,
                    "unique_key" => "driver_reached_to_pickup_point",
                ],
                [
                    "title" => "Ride cancelled by driver",
                    "english_content" => "Ride cancelled by driver",
                    "german_content" => "Fahrt vom Fahrer abgesagt",
                    "service_provider_id" => $verifyUser->id,
                    "unique_key" => "ride_cancelled_by_driver",
                ]
            ]);

            $voucherValue = [
                "mile_per_ride" => "10",
                "mile_to_currency" => "1",
                "mile_on_invitation" => "5"
            ];
            Voucher::insert([
                [
                    "key" => "_configuration",
                    "value" => json_encode($voucherValue),
                    "service_provider_id" => $verifyUser->id,
                ]
            ]);

            // $data['user'] = $user;
            // $data['driver'] = $driver;
            // $data['serviceProvider'] = $verifyUser;
            // $data['password'] = $password;
            // // dd($data);
            // $message = "Your e-mail is verified. We sent a mail with your login details.";
            return redirect()->route('service-provider.register_step1', ['token' => $token]);

            // Mail::send('email.sendLoginDetailsToServiceProvider', ['data' => $data], function ($message) use ($verifyUser) {
            // 	$message->to($verifyUser->email);
            // 	$message->subject('Welcome Mail');
            // });
            // return redirect()->route('adminLogin')->with('success', $message);
        } else {
            $message = 'Sorry your email cannot be identified.';
            return redirect()->route('adminLogin')->with('error', $message);
        }
    }

    public function register_step1(Request $request)
    {
        $input = $request->all();
        if ($request->token) {
            $user_exist = User::where(['is_email_verified_token' => $request->token])->first();
            if ($user_exist) {
                $drivers = User::where(['user_type' =>  2, 'service_provider_id' => $user_exist->id])->get();
                return view('service_provider.register_step1')->with(['token' => $input['token'], 'drivers' => $drivers]);
            }
        }
        return abort(404);
    }

    public function register_step1_submit(Request $request)
    {
        $input = $request->all();
        $rules = [
            'first_name.*' => 'required',
            'last_name.*' => 'required',
            'country_code.*' => 'required',
            'phone.*' =>  [
                'required',
                // Rule::unique('users')->where(function ($query) {
                //     return $query->where('user_type', 3);
                // }),
            ],
            'password.*' => 'required|min:6',
            'password_confirmation.*' => 'required|min:6|same:password.*',
        ];
        $request->validate(
            $rules,
            [
                'first_name.*.required' => __('The first name field is required.'),
                'last_name.*.required' => __('The surname field is required.'),
                'phone.*.required' => __('The mobile number field is required.'),
                'password.*.required' => __('The password field is required.'),
                'password.*.min' => __('The password must be at least 6 characters.'),
                'password_confirmation.*.required' => __('The confirm password field is required.'),
                'password_confirmation.*.min' => __('The confirm password must be at least 6 characters.'),
                'password_confirmation.*.same.*' => __("The password and confirm password must match.")
            ]
        );
        if ($request->service_provider_token) {
            $user_exist = User::where(['is_email_verified_token' => $request->service_provider_token])->first();
            if ($user_exist) {
                foreach ($input['first_name'] as $key => $value) {
                    $driver = User::firstOrNew(['id' => $input['driver_id'][$key]]);
                    $driver->fill([
                        'first_name' => $value,
                        'last_name' => $input['last_name'][$key],
                        'country_code' => $input['country_code'][$key],
                        'phone' => $input['phone'][$key],
                        'is_master' => 1,
                        'user_type' => 2,
                        'password' => Hash::make($input['password'][$key]),
                        'service_provider_id' => $user_exist->id,
                    ]);
                    $driver->save();
                }
                return redirect()->route('service-provider.register_step2', ['token' => $request->service_provider_token]);
            }
        }
        return abort(404);
    }

    public function register_step2(Request $request)
    {
        $input = $request->all();
        if ($request->token) {
            $user_exist = User::where(['is_email_verified_token' => $request->token])->first();
            if ($user_exist) {
                $prices = Price::where(['status' =>  1, 'service_provider_id' => $user_exist->id])->get();
                return view('service_provider.register_step2')->with(['token' => $input['token'], 'prices' => $prices]);
            }
        }
        return abort(404);
    }

    public function register_step2_submit(Request $request)
    {
        $input = $request->all();
        $rules = [
            'basic_fee.*' => 'required',
            'price_per_km.*' => 'required'
        ];
        $request->validate(
            $rules,
            [
                'basic_fee.*.required' => __('The start fee field is required.'),
                'price_per_km.*.required' => __('The price per km field is required.')
            ]
        );
        if ($request->service_provider_token) {
            $user_exist = User::where(['is_email_verified_token' => $request->service_provider_token])->first();
            if ($user_exist) {
                foreach ($input['basic_fee'] as $key => $value) {
                    $priceObj = Price::firstOrNew(['id' => $input['price_id'][$key]]);
                    $priceObj->fill([
                        'basic_fee' => $value,
                        'price_per_km' => $input['price_per_km'][$key]
                    ]);
                    $priceObj->save();
                }
                return redirect()->route('service-provider.register_step3', ['token' => $request->service_provider_token]);
            }
        }
        return abort(404);
    }

    public function register_step3(Request $request)
    {
        $input = $request->all();
        if ($request->token) {
            $user_exist = User::where(['is_email_verified_token' => $request->token])->first();
            if ($user_exist) {
                $prices = Price::with('cars')->where(['status' =>  1, 'service_provider_id' => $user_exist->id])->get();
                return view('service_provider.register_step3')->with(['token' => $input['token'], 'prices' => $prices]);
            }
        }
        return abort(404);
    }

    public function register_step3_submit(Request $request)
    {
        $input = $request->all();
        $rules = [
            'model.*' => 'required',
            'vehicle_number_plate.*' => 'required'
        ];
        $request->validate(
            $rules,
            [
                'model.*.required' => __('The car model field is required.'),
                'vehicle_number_plate.*.required' => __('The number plate field is required.')
            ]
        );
        if ($request->service_provider_token) {
            $user_exist = User::where(['is_email_verified_token' => $request->service_provider_token])->first();
            if ($user_exist) {
                foreach ($input['model'] as $key => $value) {
                    $vehicleObj = Vehicle::firstOrNew(['id' => $input['vehicle_id'][$key]]);
                    $vehicleObj->fill([
                        'model' => $value,
                        'vehicle_number_plate' => $input['vehicle_number_plate'][$key]
                    ]);
                    $vehicleObj->save();
                }
                return redirect()->route('service-provider.registeration_finish');
            }
        }
        return abort(404);
    }

    public function registeration_finish(Request $request)
    {
        return view('service_provider.registeration_finish');
    }
}
