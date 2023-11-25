<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

 Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('storage:link');
    return "Cache is cleared";
});

/****	GLOBAL VARIABLE	***/
Config::set('limit', 10);

Route::get('log-viewer', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
Route::get('/test_notification',  ['as'=>'test_notification','uses'=>'PageController@test_notification']);
########		PUBLIC URL START		#########
/* Route::get('/', function () {
   return 'No Home Yet';
}); */
Route::get('/',  ['as'=>'about','uses'=>'PageController@home']);
Route::get('/phpinfo',  ['as'=>'about','uses'=>'PageController@phpinfo']);
Route::get('/about',  ['as'=>'about','uses'=>'PageController@about_front']);
Route::get('/terms',  ['as'=>'terms','uses'=>'PageController@terms_front']);
Route::get('/policy',  ['as'=>'policy','uses'=>'PageController@policy_front']);
Route::get('/cron/scheduleRide',  ['uses'=>'PageController@scheduleRide']);
Route::get('/cron/rideAboutToStart',  ['uses'=>'CronController@rideAboutToStart']);
Route::get('/cron/driverForScheduleRide',  ['uses'=>'CronController@driverForScheduleRide']);
Route::get('/cron/autoCancel',  ['uses'=>'CronController@autoCancel']);
Route::get('/cron/testing',  ['uses'=>'CronController@testing']);
Route::get('/cron/notification',  ['uses'=>'CronController@notification']);
Route::get('/cron/shareRideExecute',  ['uses'=>'CronController@shareRideExecute']);

Route::group(['middleware' => 'locale'], function(){

	//Route::get('/rides/{type?}','PageController@booking')->name('guest.rides');

	// Route::get('/taxisteinemann/booking',  ['uses'=>'PageController@booking'])->name('booking_taxisteinemann');
	// Route::post('/taxisteinemann/booking_form',  ['uses'=>'PageController@booking_form'])->name('booking_form_taxisteinemann');
	// Route::get('/taxisteinemann/list_of_booking/{token?}',  ['uses' => 'PageController@list_of_booking'])->name('list_of_booking_taxisteinemann');
	// Route::get('/taxisteinemann/booking_details/{id}',  ['uses' => 'PageController@booking_details'])->name('booking_details_taxisteinemann');
	// Route::get('/taxisteinemann/booking_edit/{id}',  ['uses' => 'PageController@booking_edit'])->name('booking_edit_taxisteinemann');
	// Route::post('/taxisteinemann/booking_form_edit/{id}',  ['uses' => 'PageController@booking_form_edit'])->name('booking_form_edit_taxisteinemann');

	// Route::get('/taxi2000/booking',  ['uses'=>'BookingTaxi2000Controller@booking'])->name('booking_taxi2000');
	// Route::post('/taxi2000/booking_form',  ['uses'=>'BookingTaxi2000Controller@booking_form'])->name('booking_form_taxi2000');
	// Route::get('/taxi2000/list_of_booking/{token?}',  ['uses' => 'BookingTaxi2000Controller@list_of_booking'])->name('list_of_booking_taxi2000');
	// Route::get('/taxi2000/booking_details/{id}',  ['uses' => 'BookingTaxi2000Controller@booking_details'])->name('booking_details_taxi2000');
	// Route::get('/taxi2000/booking_edit/{id}',  ['uses' => 'BookingTaxi2000Controller@booking_edit'])->name('booking_edit_taxi2000');
	// Route::post('/taxi2000/booking_form_edit/{id}',  ['uses' => 'BookingTaxi2000Controller@booking_form_edit'])->name('booking_form_edit_taxi2000');


	// Route::get('/booking_form',  ['uses'=>'PageController@booking_form']);
	// Route::post('/booking_form',  ['uses'=>'PageController@booking_form'])->name('booking_form');
	// Route::post('/verify_otp_before_register',  ['uses'=>'PageController@verify_otp_before_register'])->name('verify_otp_before_register');

	Route::get('/my-booking',  ['uses' => 'PageController@myBooking']);
	Route::post('/send_otp_for_my_bookings',  ['uses' => 'PageController@send_otp_for_my_bookings'])->name('send_otp_for_my_bookings');
	Route::post('/verify_otp_and_ride_list',  ['uses' => 'PageController@verify_otp_and_ride_list'])->name('verify_otp_and_ride_list');
	Route::post('/web/cancel_booking',  ['uses' => 'PageController@cancel_booking'])->name('web.cancel_booking');
	Route::post('/send_otp_before_ride_edit',  ['uses' => 'PageController@send_otp_before_ride_edit'])->name('send_otp_before_ride_edit');
	Route::post('/verify_otp_and_ride_booking_edit',  ['uses' => 'PageController@verify_otp_and_ride_booking_edit'])->name('verify_otp_and_ride_booking_edit');
	Route::post('/change-locale',  ['uses' => 'PageController@changeLocale'])->name('changeLocale');
});

// Route::get('note/{slug}', 'TopicController@note');
########		PUBLIC URL END			#########

Route::group(['middleware' => 'guest'], function(){
	// Route::get('/about',  ['as'=>'about','uses'=>'PageController@about_front']);
    Route::get('/admin',  ['as'=>'adminLogin','uses'=>'UserController@login']);
    Route::post('/doLogin',  ['uses'=>'UserController@doLogin']);
    Route::get('/register',  ['as'=>'service-provider.register','uses'=>'ServiceProviderController@register']);
    Route::post('/service-provider/register_submit',  ['as'=>'service-provider.register_submit', 'uses'=>'ServiceProviderController@register_submit']);
	Route::get('/service-provider/verify/{token}',  ['as'=>'serviceProviderVerify','uses'=>'ServiceProviderController@serviceProviderVerify']);
	Route::get('service-provider/register_step1',  ['as'=>'service-provider.register_step1','uses'=>'ServiceProviderController@register_step1']);
	Route::post('service-provider/register_step1_submit',  ['as'=>'service-provider.register_step1_submit','uses'=>'ServiceProviderController@register_step1_submit']);
	Route::get('service-provider/register_step2',  ['as'=>'service-provider.register_step2','uses'=>'ServiceProviderController@register_step2']);
	Route::post('service-provider/register_step2_submit',  ['as'=>'service-provider.register_step2_submit','uses'=>'ServiceProviderController@register_step2_submit']);
	Route::get('service-provider/register_step3',  ['as'=>'service-provider.register_step3','uses'=>'ServiceProviderController@register_step3']);
	Route::post('service-provider/register_step3_submit',  ['as'=>'service-provider.register_step3_submit','uses'=>'ServiceProviderController@register_step3_submit']);
	Route::get('service-provider/registration_finish',  ['as'=>'service-provider.registration_finish','uses'=>'ServiceProviderController@registration_finish']);
	
	Route::get('/verify/{email}',  ['as'=>'verify','uses'=>'UserController@verify']);
	Route::post('/verifyOtp',  ['uses'=>'UserController@verifyOtp']);
	Route::post('/do-login-guest',  ['uses'=>'UserController@doLoginGuest']);

    Route::post('/do-register-guest',  ['uses'=>'UserController@doRegisterGuest']);

	Route::get('/verify-otp',  ['as'=>'verify','uses'=>'UserController@verifyOtpGuest']);
	Route::post('/otp-verification',  ['uses'=>'UserController@otpVerification']);

	Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
	Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
	Route::post('/password/reset/{token}', 'Auth\ResetPasswordController@reset');
	Route::get('/password/success', ['as'=>'password.success','uses'=>'UserController@guest_message']);
});



Route::group(['middleware' => 'auth'], function () {
	Route::get('dashboard',  ['as' => 'users.dashboard', 'uses' => 'UserController@dashboard']);
	Route::get('my-profile',  ['as' => 'my-profile', 'uses' => 'UserController@myProfile']);
	Route::post('my-profile',  ['as' => 'my-profile', 'uses' => 'UserController@myProfile']);
	Route::get('logout',  ['as' => 'logout','uses' => 'UserController@logout']);
});

Route::group(['prefix' => 'admin',  'middleware' => 'auth'], function () {
	Route::get('/users/list',  ['as' => 'users.index', 'uses' => 'UserController@index']);
	Route::get('/drivers/list',  ['as' => 'drivers.index', 'uses' => 'DriverController@index']);
	Route::get('/users/import',  ['as' => 'users.import', 'uses' => 'UserController@userImport']);
	Route::get('/users/profile',  ['as' => 'users.profile', 'uses' => 'UserController@profile']);
	Route::get('/users/settings',  ['as' => 'users.settings', 'uses' => 'UserController@settings']);
	Route::get('/users/vouchers',  ['as' => 'users.voucher', 'uses' => 'UserController@vouchers']);
	Route::get('/vouchers/create',  ['as' => 'voucher.create', 'uses' => 'UserController@createVoucher']);
	Route::match(['put', 'patch'], '/users/vouchersUpdate', ['as' => 'users.vouchersUpdate', 'uses' => 'UserController@vouchersUpdate']);
	Route::match(['put', 'patch'], '/users/{user}/profileUpdate', ['as' => 'users.profileUpdate', 'uses' => 'UserController@profileUpdate']);
	Route::match(['put', 'patch'], '/users/settingsUpdate', ['as' => 'users.settingsUpdate', 'uses' => 'UserController@settingsUpdate']);
	Route::match(['put', 'patch'], '/users/{user}/changePassword', ['as' => 'users.changePassword', 'uses' => 'UserController@changePassword']);
	Route::resources(['bookings' => 'BookingController']);
	Route::get('/update-lat-long', 'UserController@updateLatLong');
	Route::get('expenses/type_list', 'ExpensesController@type_list')->name('expenses.type_list');
	Route::post('expenses/type_add', 'ExpensesController@type_add')->name('expenses.type_add');
	Route::post('expenses/type_edit', 'ExpensesController@type_edit')->name('expenses.type_edit');
	Route::post('expenses/type_delete', 'ExpensesController@type_delete')->name('expenses.type_delete');
	Route::get('expenses/list', 'ExpensesController@list')->name('expenses.list');
	Route::get('expenses/show/{id}', 'ExpensesController@show')->name('expenses.show');

	Route::get('temporary_user/only_phone', 'TemporaryUserController@only_phone')->name('temporary_users.only_phone');
	Route::get('temporary_user/only_last_name', 'TemporaryUserController@only_last_name')->name('temporary_users.only_last_name');
});

Route::group(['prefix' => 'admin',  'middleware' => 'role_or_permission:Administrator'], function(){
	Route::get('/booking/{id}/user','BookingController@userDetail');
	//driver driver/edit
	Route::get('/drivers',  ['as'=>'users.drivers','uses'=>'UserController@driver']);
	Route::post('/driver/make_driver_logout',  ['as'=>'driver.make_driver_logout','uses'=>'UserController@make_driver_logout']);
	Route::get('driver/edit/{id}','UserController@editDriver');
	Route::match(['put', 'patch'],'driver/update/{id}','UserController@updateDriver');
	Route::get('driver/create','UserController@createDriver');
	Route::post('driver/checkDriverByPhone','UserController@checkDriverByPhone')->name('checkDriverByPhone');
	Route::get('driver/service-provider/add/{id}','UserController@addDriverServiceProvider')->name('addDriverServiceProvider');
	Route::get('driver/{id}','UserController@showDriver')->name('showDriver');
	Route::post('driver/delete','DriverController@destroy')->name('admin.driver.delete');
	Route::match(['put', 'patch'], '/users/storeImport',['as'=>'users.storeImport','uses'=>'UserController@storeImport']);
	
	Route::get('/drivers/regular',  ['as'=>'drivers.regular','uses'=>'DriverController@regularDriver']);
	Route::get('/drivers/master',  ['as'=>'drivers.master','uses'=>'DriverController@masterDriver']);
	
	Route::resources(['users'=>'UserController','category'=>'CategoryController','payment-method'=>'PaymentManagementController','admin-control'=>'AdminControlController','contact-support'=>'ContactSupportController',
	'notifications'=>'NotificationController','social-media-setting'=>'SettingController','company'=>'CompanyController','drivers'=>'DriverController','vehicle'=>'VehicleController','vehicle-type'=>'VehicleTypeController','vouchers-offers'=>'VoucherController','promotion'=>'PromotionController','rides'=>'RideController']);
	Route::resources(['push-notifications'=>'PushNotificationController']);

	Route::get('daily-report','DailyReportController@index')->name('daily-report.index');
	Route::get('report/vehicles','DailyReportController@vehicles')->name('daily-report.vehicles');
	Route::post('report/vehicle_export','DailyReportController@vehicle_export')->name('daily-report.vehicle_export');
	Route::get('report/vehicle_mileage','DailyReportController@vehicle_mileage')->name('daily-report.vehicle_mileage');
	Route::post('report/vehicle_mileage_export','DailyReportController@vehicle_mileage_export')->name('daily-report.vehicle_mileage_export');
	Route::get('report/expenses','DailyReportController@expenses')->name('daily-report.expenses');
	Route::post('report/expenses_export','DailyReportController@expenses_export')->name('daily-report.expenses_export');

	Route::post('vehicle-type/change_status','VehicleTypeController@change_status');
	Route::post('vehicle-type/delete','VehicleTypeController@destroy');
    Route::post('company/delete','CompanyController@destroy');
	Route::post('company/change_status','CompanyController@change_status');
	Route::post('driver/driver_master_status','UserController@driver_change_status');
	Route::post('users/invoice_status','UserController@invoice_change_status');
	Route::post('vehicle/delete','VehicleController@destroy');
	Route::post('vehicle/carFree','VehicleController@carFree');

	Route::get('scheduled-rides','BookingController@scheduledRide');
	Route::get('scheduled-ride/{id}','BookingController@scheduledRideShow');
	Route::get('get_users','ContactSupportController@getUsers');
	Route::get('complaints','ContactSupportController@index');
	Route::post('reply-to-user','ContactSupportController@replyToUser');
	Route::get('booking/{type}','BookingController@booking');
	Route::get('promotional-offer','NotificationController@promotionalOffer');
	Route::post('store-promotional-offer','NotificationController@storePromotionalOffer');
	Route::get('payment-setting','SettingController@paymentSetting');
	Route::post('payment-setting-store','SettingController@paymentSettingStore');

	Route::get('/page/about',  ['as'=>'page.about','uses'=>'PageController@about']);
	Route::get('/page/terms',  ['as'=>'page.terms','uses'=>'PageController@terms']);
	Route::get('/page/policy',  ['as'=>'page.policy','uses'=>'PageController@policy']);
	Route::match(['put', 'patch'], '/page/store',['as'=>'page.store','uses'=>'PageController@store']);
	Route::get('user/{id}/bookings/','UserController@userBooking');
	Route::get('driver/{id}/bookings/','UserController@driverBooking');
	Route::get('/exportExcel/{type}','UserController@exportExcel');
	Route::get('/export-booking/{id?}','BookingController@exportExcel');
	Route::get('ride/export','RideController@rideExport')->name('ride/export');
	Route::delete('ride/delete_multiple','RideController@delete_multiple')->name('ride/delete_multiple');
	Route::get('vehicle_export','VehicleController@vehicleExport')->name('vehicle_export');
	Route::resources(['sms-template'=>'SMSTemplateController']);
});
Route::group(['prefix' => 'admin',  'middleware' => 'role_or_permission:Company'], function(){
	Route::get('{id}/{type}/user/','BookingController@bookingUserDetail');
	Route::get('past-bookings','BookingController@pastBooking');
	Route::get('upcoming-bookings','BookingController@upcomingBooking');
	Route::get('current-bookings','BookingController@currentBooking');
	Route::get('/notifications','NotificationController@companyNotifications');
	Route::get('/task-management','BookingController@home');
	Route::post('ride-create','BookingController@rideCreate');
	Route::get('/past-bookings-detail/{id}','BookingController@pastBookingDetail');
	Route::get('/upcoming-bookings-detail/{id}','BookingController@upcomingBookingDetail');
	Route::get('/admin-contact','ContactSupportController@adminContact');
	Route::post('/send-to-admin','ContactSupportController@sendToAdmin');
	Route::get('/book-ride','RideManagementController@bookRide');
});

Route::group(['prefix' => 'company',  'middleware' => ['auth','role_or_permission:Company']], function(){
	Route::get('/rides/{type?}','Company\RidesController@index')->name('company.rides');
	Route::delete('ride/delete_multiple','Company\RidesController@delete_multiple')->name('company.rides.delete_multiple');
	// Route::get('rides/{id}','Company\RidesController@show')->name('company.rides.show');
	// Route::delete('rides/{id}','Company\RidesController@destroy')->name('company.rides.destroy');
	Route::post('settings/update-company-information','CompanyController@updateCompanyInformation')->name('company.updateCompanyInformation')->middleware('can:isCompany');
	Route::post('settings/update-company-theme-information','CompanyController@updateCompanyThemeInformation')->name('company.updateCompanyThemeInformation')->middleware('can:isCompany');

	Route::post('settings/update-personal-information','CompanyController@updatePersonalInformation')->name('company.updatePersonalInformation');

	Route::get('settings','CompanyController@settings')->name('company.settings');
	Route::resource('managers','Company\ManagersController')->middleware('can:isCompany');
	Route::post('/ride_booking','Company\RidesController@ride_booking')->name('company.ride_booking');
	Route::get('/rides-history','Company\RidesController@history')->name('company.rides.history');
	Route::get('rides-edit','Company\RidesController@edit')->name('company.rides.edit');
	Route::get('rides-driver_detail','Company\RidesController@ride_driver_detail')->name('company.rides.driver_detail');
	Route::post('rides/detail/{id}','Company\RidesController@ride_detail')->name('company.ride_detail');
	Route::post('/ride_booking_update','Company\RidesController@ride_booking_update')->name('company.ride_booking_update');
	Route::post('/cancel_booking','Company\RidesController@cancel_booking')->name('company.cancel_booking');
	Route::post('/delete_booking','Company\RidesController@delete_booking')->name('company.delete_booking');

});

Route::group(['prefix' => '{slug}','middleware' => 'guest_user'], function () {
	Route::get('/booking/{type?}', 'Guest\RidesController@index')->name('guest.rides');
	Route::delete('ride/delete_multiple', 'Guest\RidesController@delete_multiple')->name('guest.rides.delete_multiple');
	Route::post('/ride_booking', 'Guest\RidesController@ride_booking')->name('guest.ride_booking');
	Route::post('/user_exist', 'Guest\RidesController@user_exist')->name('guest.user_exist');
	Route::get('/rides-history', 'Guest\RidesController@history')->name('guest.rides.history');
	Route::get('rides-edit', 'Guest\RidesController@edit')->name('guest.rides.edit');
	Route::get('rides-driver_detail', 'Guest\RidesController@ride_driver_detail')->name('guest.rides.driver_detail');
	Route::post('rides/detail/{id}', 'Guest\RidesController@ride_detail')->name('guest.ride_detail');
	Route::post('/ride_booking_update', 'Guest\RidesController@ride_booking_update')->name('guest.ride_booking_update');
	Route::post('/cancel_booking', 'Guest\RidesController@cancel_booking')->name('guest.cancel_booking');
	Route::post('/delete_booking', 'Guest\RidesController@delete_booking')->name('guest.delete_booking');
	Route::post('/send_otp_before_ride_booking',  ['uses'=>'Guest\RidesController@send_otp_before_ride_booking'])->name('guest.send_otp_before_ride_booking');
	Route::post('/verify_otp_and_ride_booking',  ['uses'=>'Guest\RidesController@verify_otp_and_ride_booking'])->name('guest.verify_otp_and_ride_booking');

	Route::get('guest-login',  'Guest\LoginController@guestLogin')->name('guest.login');
	Route::get('guest-register',  'Guest\LoginController@guestRegister')->name('guest.register');
	Route::post('do-register-guest',  ['uses'=>'Guest\LoginController@doRegisterGuest'])->name('do-register-guest');
	Route::post('/send_otp_before_register',  ['uses'=>'Guest\LoginController@send_otp_before_register'])->name('send_otp_before_register');
	Route::post('/verify_otp_before_register',  ['uses'=>'Guest\LoginController@verify_otp_before_register'])->name('verify_otp_before_register');
	Route::post('/send_otp_forgot_password',  ['uses'=>'Guest\LoginController@send_otp_forgot_password'])->name('send_otp_forgot_password');
	Route::post('/verify_otp_forgot_password',  ['uses'=>'Guest\LoginController@verify_otp_forgot_password'])->name('verify_otp_forgot_password');
	Route::get('forget-password',  'Guest\LoginController@forgetPassword')->name('forget.password');
	Route::post('forget-password',  'Guest\LoginController@changeForgetPassword')->name('change.forget.password');
	Route::group(['middleware' => 'guest'], function(){
		Route::post('/do-login-guest',  ['uses'=>'Guest\LoginController@doLoginGuest'])->name('do-login-guest');
	});
	Route::group(['middleware' => 'auth'], function () {
		Route::get('logout',  ['as' => 'guest.logout','uses' => 'Guest\LoginController@logout']);
	});
});

Route::resource('company-users','Company\UsersController')->middleware(['auth','role_or_permission:Company']);
Route::post('company-users/check-user-info-btn','Company\UsersController@checkUserInfoBtn')->name('checkUserInfoBtn')->middleware(['auth','role_or_permission:Company']);

Route::group(['prefix' => 'admin',  'middleware' => 'role_or_permission:Company|Administrator'], function(){
		Route::resources(['users'=>'UserController']);
		//Route::get('{id}/{type}/user/','BookingController@bookingUserDetail');
});


Route::get('/book-ride','RideManagementController@bookRide');
Route::group([ 'middleware' => 'auth'], function(){
	// Route::post('/userCreate',  ['as'=>'userCreate','uses'=>'UserController@userCreate']);
});

Route::get('company-login',  ['as'=>'company_login','uses'=>'Company\LoginController@login']);

Route::get('/privacy_policy','PageController@privacy_policy');

/* Master admin */
Route::get('master-login',  'MasterAdmin\LoginController@login');
Route::post('adminLogin',  [ 'uses' => 'MasterAdmin\LoginController@masterLogin'])->name('masterLogin');
Route::group(['middleware' => 'auth'], function () {
	Route::get('master-dashboard',  ['as' => 'masterAdmin.dashboard', 'uses' => 'MasterAdmin\UsersController@dashboard']);
	Route::get('service-provider',  'MasterAdmin\ServiceProviderController@getAllServiceProvider');
	Route::get('master-setting',  'MasterAdmin\UsersController@getSettings');
	Route::get('master-plan',  'MasterAdmin\PlansController@getServiceProviderPlan');
	Route::get('plan-detail',  'MasterAdmin\PlansController@getPlanDetail');
	Route::get('billing',  'MasterAdmin\PlansController@getBillingDetail');
	Route::get('master-logout',  ['as' => 'logout','uses' => 'MasterAdmin\UsersController@logout']);
	Route::post('updateServiceProvider',  [ 'uses' => 'MasterAdmin\ServiceProviderController@updateServiceProvider'])->name('updateServiceProvider');

});