<?php

namespace App\Http\Controllers;

use App\PaymentMethod;
use App\Price;
use App\ServiceProviderDriver;
use App\Setting;
use App\SMSTemplate;
use App\User;
use App\Vehicle;
use App\Voucher;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail as FacadesMail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ServiceProviderController extends Controller
{

    public function register()
    {
        $breadcrumb = array('title' => 'Home', 'action' => 'Register');
        $data = [];
        $data = array_merge($breadcrumb, $data);
        return view('service_provider.register')->with($data);
    }

    public function register_submit(Request $request)
    {
        $input = $request->all();
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'site_name' => 'required',
            'addresses' => 'required',
            'zip' => 'required',
            'city' => 'required',
            'country' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->where(function ($query) {
                    return $query->where('user_type', 3);
                }),
            ],
            'country_code' => 'required',
            'phone' => [
                'required',
                Rule::unique('users')->where(function ($query) {
                    return $query->where('user_type', 3);
                }),
            ],
        ];
        $request->validate(
            $rules,
            [
                'site_name.required' => 'Please enter your company name',
                'addresses.required' => 'You have to choose the file!',
                'zip.required' => 'Please enter your zip code',
            ]
        );
        try {
            $serviceProvider = new User();
            $phone_number = str_replace(' ', '', ltrim($request->phone, "0"));
            if (str_contains($phone_number, "+" . $request->country_code)) {
                $phone_number = str_replace("+" . $request->country_code, '', $phone_number);
            }
            $serviceProvider->fill([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'name' => $request->site_name,
                'addresses' => $request->addresses,
                'city' => $request->city,
                'country' => $request->country,
                'country_code' => $request->country_code,
                'phone' => $phone_number,
                'country_code_iso' => $request->country_code_iso??null,
                'email' => $request->email,
                'user_type' => 3                
            ]);
            $serviceProvider->save();
            $token = Str::random(64) . '-' . $serviceProvider->id;
            $serviceProvider->is_email_verified_token = $token;
            $serviceProvider->save();

            FacadesMail::send('email.emailVerificationEmail', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Email Verification Mail');
            });
            return redirect()->back()->with('success', __('Thank you for registering with Veldoo. Check your mail for a confirmation email.'));
        } catch (Exception $e) {
            Log::info('Exception in ' . __FUNCTION__ . ' in ' . __CLASS__ . ' in ' . $e->getLine() . ' --- ' . $e->getMessage());
            return redirect()->back()->withInput($input)->with('error', $e->getMessage());
        }
    }

    public function serviceProviderVerify($token)
    {
        $verifyUser = User::where('is_email_verified_token', $token)->first();
        if (!is_null($verifyUser)) {
            if ($verifyUser->is_email_verified == 0) {
                $verifyUser->is_email_verified = 1;
                $verifyUser->update();

                $driver = new User();
                $driver->fill([
                    'email' => $verifyUser->email,
                    'first_name' => $verifyUser->first_name,
                    'last_name' => $verifyUser->last_name,
                    'country_code' => $verifyUser->country_code,
                    'phone' => $verifyUser->phone,
                    'country_code_iso' => $verifyUser->country_code_iso,
                    'is_master' => 1,
                    'user_type' => 2,
                    'service_provider_id' => $verifyUser->id,
                ]);
                $driver->save();
                $serviceProviderDriver = new ServiceProviderDriver();
                $serviceProviderDriver->fill(['service_provider_id' => $verifyUser->id, 'driver_id' => $driver->id]);
                $serviceProviderDriver->save();
                //customer
                // $user = new User();
                // $user->fill([
                //     'email' => 'user_' . $verifyUser->email,
                //     'first_name' => $verifyUser->first_name,
                //     'last_name' => $verifyUser->last_name,
                //     'country_code' => $verifyUser->country_code,
                //     'phone' => $verifyUser->phone,
                //     'user_type' => 1,
                //     'verify' => 1,
                //     'password' => Hash::make($password),
                //     'service_provider_id' => $verifyUser->id,
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
                    "waiting_ride_distance_addition" => "15",
                    "temporary_phone_number_users" => "40",
                    "temporary_last_name_users" => "20",
                    "driver_count_to_display" => "3",
                    "want_send_sms_to_user_when_ride_accepted_by_driver" => 1,
                    "want_send_sms_to_user_when_driver_reached_to_pickup_point" => 1,
                    "want_send_sms_to_user_when_driver_cancelled_the_ride" => 1
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
                    'model' => "Car 1",
                    'vehicle_number_plate' => "AA11",
                    'service_provider_id' => $verifyUser->id,
                ]);
                $vehicle->save();
                $vehicle = new Vehicle();
                $vehicle->fill([
                    'category_id' => $vehicleType->id,
                    'year' => date('Y'),
                    'model' => "Car 2",
                    'vehicle_number_plate' => "BB22",
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
                    'model' => "Car 3",
                    'vehicle_number_plate' => "CC33",
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
                    ],
                ]);

                $voucherValue = [
                    "mile_per_ride" => "10",
                    "mile_to_currency" => "1",
                    "mile_on_invitation" => "5",
                ];

                $paymentMethodObj = new PaymentMethod();
                $paymentMethodObj->fill([
                    'name' => 'Cash',
                    'status' => 1,
                    'service_provider_id' => $verifyUser->id
                ]);
                $paymentMethodObj->save();
                $paymentMethodObj = new PaymentMethod();
                $paymentMethodObj->fill([
                    'name' => 'Card',
                    'status' => 1,
                    'service_provider_id' => $verifyUser->id
                ]);
                $paymentMethodObj->save();
                $paymentMethodObj = new PaymentMethod();
                $paymentMethodObj->fill([
                    'name' => 'Other',
                    'status' => 1,
                    'service_provider_id' => $verifyUser->id
                ]);
                $paymentMethodObj->save();

                Voucher::insert([
                    [
                        "key" => "_configuration",
                        "value" => json_encode($voucherValue),
                        "service_provider_id" => $verifyUser->id,
                    ],
                ]);

                FacadesMail::send('email.updateDriverDetailLinkToServiceProvider', ['token' => $token], function ($message) use ($verifyUser) {
                    $message->to($verifyUser->email);
                    $message->subject('Update Credentials Link');
                });

                FacadesMail::send('email.updateDriverDetailLinkToServiceProvider', ['token' => $token], function ($message) use ($verifyUser) {
                    $message->to($verifyUser->email);
                    $message->subject('Update Credentials Link');
                });
            }
            // $data['user'] = $user;
            // $data['driver'] = $driver;
            // $data['serviceProvider'] = $verifyUser;
            // $data['password'] = $password;
            // // dd($data);
            // $message = "Your e-mail is verified. We sent a mail with your login details.";
            return redirect()->route('service-provider.register_step1', ['token' => $token]);

            // return redirect()->route('adminLogin')->with('success', $message);
        } else {
            $message = 'Sorry your email cannot be identified.';
            return redirect()->route('service-provider.register')->with('error', $message);
        }
    }

    public function selectPlan($token)
    {
      try{
            return view('service_provider.select_plan');
      }catch(Exception $e){
        Log::info('Error in method selectPlan'. $e);
      }

    }

    public function register_step1(Request $request)
    {
        $input = $request->all();
        if ($request->token) {
            $user_exist = User::where(['is_email_verified_token' => $request->token])->first();
            if ($user_exist) {
                $drivers = User::where(['user_type' => 2, 'service_provider_id' => $user_exist->id])->get();
                return view('service_provider.register_step1')->with(['token' => $input['token'], 'drivers' => $drivers]);
            }
        }
        return abort(404);
    }

    public function register_step1_submit(Request $request)
    {
        $input = $request->all();
        $rules = [
            'first_name.0' => 'required',
            'last_name.0' => 'required',
            'country_code.0' => 'required',
            'phone.0' => [
                'required',
            ],
        ];
        $request->validate(
            $rules,
            [
                'first_name.0.required' => __('The first name field is required.'),
                'last_name.0.required' => __('The surname field is required.'),
                'phone.0.required' => __('The mobile number field is required.'),
            ]
        );
        if (!empty($request->password[0])) {
            $rules = [
                'password.0' => 'required|min:6',
                'password_confirmation.0' => 'required|min:6|same:password.0',
            ];
            $request->validate(
                $rules,
                [
                    'password.0.required' => __('The password field is required.'),
                    'password.0.min' => __('The password must be at least 6 characters.'),
                    'password_confirmation.0.required' => __('The confirm password field is required.'),
                    'password_confirmation.0.min' => __('The confirm password must be at least 6 characters.'),
                    'password_confirmation.0.same' => __('The password confirmation and password must match.'),
                ]
            );
        }
        if (!empty($request->first_name[1])) {
            $rules = [
                'last_name.1' => 'required',
                'country_code.1' => 'required',
                'phone.1' => [
                    'required',
                ],
            ];
            $request->validate(
                $rules,
                [
                    'last_name.1.required' => __('The surname field is required.'),
                    'phone.1.required' => __('The mobile number field is required.'),
                ]
            );
            if (!empty($request->password[1])) {
                $rules = [
                    'password.1' => 'required|min:6',
                    'password_confirmation.1' => 'required|min:6',
                ];
                $request->validate(
                    $rules,
                    [
                        'password.1.required' => __('The password field is required.'),
                        'password.1.min' => __('The password must be at least 6 characters.'),
                        'password_confirmation.1.required' => __('The confirm password field is required.'),
                        'password_confirmation.1.min' => __('The confirm password must be at least 6 characters.'),
                        'password_confirmation.1.same' => __('The password confirmation and password must match.'),
                    ]
                );
            }
            $phone_number0 = str_replace(' ', '', ltrim($input['phone'][0], "0"));
            if (str_contains($phone_number0, "+" . $input['country_code'][0])) {
                $phone_number0 = str_replace("+" . $input['country_code'][0], '', $phone_number0);
            }
            $phone_number1 = str_replace(' ', '', ltrim($input['phone'][1], "0"));
            if (str_contains($phone_number1, "+" . $input['country_code'][1])) {
                $phone_number1 = str_replace("+" . $input['country_code'][1], '', $phone_number1);
            }
            if($phone_number0 == $phone_number1){
                return redirect()->back()->with('error', __("Each driver must have a unique phone number."));
            }
        }
        if ($request->service_provider_token) {
            $user_exist = User::where(['is_email_verified_token' => $request->service_provider_token])->first();
            if ($user_exist) {
                foreach ($input['first_name'] as $key => $value) {
                    if (!empty($value)) {
                        $driver = User::firstOrNew(['id' => $input['driver_id'][$key]]);
                        $phone_number = str_replace(' ', '', ltrim($input['phone'][$key], "0"));
                        if (str_contains($phone_number, "+" . $input['country_code'][$key])) {
                            $phone_number = str_replace("+" . $input['country_code'][$key], '', $phone_number);
                        }
                        $driverArray = [
                            'first_name' => $value,
                            'last_name' => $input['last_name'][$key],
                            'country_code' => $input['country_code'][$key],
                            'phone' => $phone_number,
                            'country_code_iso' => $input['country_code_iso'][$key]??"",
                            'is_master' => 1,
                            'user_type' => 2
                        ];
                        if(!empty($input['password'][$key])){
                            $driverArray['password'] = Hash::make($input['password'][$key]);
                        }
                        $driver->fill($driverArray);
                        $driver->save();
                        $serviceProviderDriver = ServiceProviderDriver::firstOrNew(['service_provider_id' => $user_exist->id, 'driver_id' => $driver->id]);
                        $serviceProviderDriver->fill(['service_provider_id' => $user_exist->id, 'driver_id' => $driver->id]);
                        $serviceProviderDriver->save();
                    }
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
                $prices = Price::where(['status' => 1, 'service_provider_id' => $user_exist->id])->get();
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
            'price_per_km.*' => 'required',
        ];
        $request->validate(
            $rules,
            [
                'basic_fee.*.required' => __('The start fee field is required.'),
                'price_per_km.*.required' => __('The price per km field is required.'),
            ]
        );
        if ($request->service_provider_token) {
            $user_exist = User::where(['is_email_verified_token' => $request->service_provider_token])->first();
            if ($user_exist) {
                foreach ($input['basic_fee'] as $key => $value) {
                    $priceObj = Price::firstOrNew(['id' => $input['price_id'][$key]]);
                    $priceObj->fill([
                        'basic_fee' => $value,
                        'price_per_km' => $input['price_per_km'][$key],
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
                $prices = Price::with('cars')->where(['status' => 1, 'service_provider_id' => $user_exist->id])->get();
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
            'vehicle_number_plate.*' => 'required',
        ];
        $request->validate(
            $rules,
            [
                'model.*.required' => __('The car model field is required.'),
                'vehicle_number_plate.*.required' => __('The number plate field is required.'),
            ]
        );
        if ($request->service_provider_token) {
            $user_exist = User::where(['is_email_verified_token' => $request->service_provider_token])->first();
            if ($user_exist) {
                foreach ($input['model'] as $key => $value) {
                    $vehicleObj = Vehicle::firstOrNew(['id' => $input['vehicle_id'][$key]]);
                    $vehicleObj->fill([
                        'model' => $value,
                        'vehicle_number_plate' => $input['vehicle_number_plate'][$key],
                    ]);
                    $vehicleObj->save();
                }
                return redirect()->route('service-provider.registration_finish');
            }
        }
        return abort(404);
    }

    public function registration_finish(Request $request)
    {
        return view('service_provider.registration_finish');
    }
}
