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
	Route::get('/taxisteinemann/booking',  ['uses'=>'PageController@booking'])->name('booking_taxisteinemann');
	Route::post('/taxisteinemann/booking_form',  ['uses'=>'PageController@booking_form'])->name('booking_form_taxisteinemann');
	Route::get('/taxisteinemann/list_of_booking/{token?}',  ['uses' => 'PageController@list_of_booking'])->name('list_of_booking_taxisteinemann');
	Route::get('/taxisteinemann/booking_edit/{id}',  ['uses' => 'PageController@booking_edit'])->name('booking_edit_taxisteinemann');
	Route::post('/taxisteinemann/booking_form_edit/{id}',  ['uses' => 'PageController@booking_form_edit'])->name('booking_form_edit_taxisteinemann');

	Route::get('/taxi2000/booking',  ['uses'=>'BookingTaxi2000Controller@booking'])->name('booking_taxi2000');
	Route::post('/taxi2000/booking_form',  ['uses'=>'BookingTaxi2000Controller@booking_form'])->name('booking_form_taxi2000');
	Route::get('/taxi2000/list_of_booking/{token?}',  ['uses' => 'BookingTaxi2000Controller@list_of_booking'])->name('list_of_booking_taxi2000');
	Route::get('/taxi2000/booking_edit/{id}',  ['uses' => 'BookingTaxi2000Controller@booking_edit'])->name('booking_edit_taxi2000');
	Route::post('/taxi2000/booking_form_edit/{id}',  ['uses' => 'BookingTaxi2000Controller@booking_form_edit'])->name('booking_form_edit_taxi2000');


	// Route::get('/booking_form',  ['uses'=>'PageController@booking_form']);
	// Route::post('/booking_form',  ['uses'=>'PageController@booking_form'])->name('booking_form');
	Route::post('/send_otp_before_ride_booking',  ['uses'=>'PageController@send_otp_before_ride_booking'])->name('send_otp_before_ride_booking');
	Route::post('/verify_otp_and_ride_booking',  ['uses'=>'PageController@verify_otp_and_ride_booking'])->name('verify_otp_and_ride_booking');
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
    Route::get('/register',  ['as'=>'companyRegister','uses'=>'UserController@register']);
    Route::post('/doRegister',  ['uses'=>'UserController@doRegister']);
     Route::get('/verify/{email}',  ['as'=>'verify','uses'=>'UserController@verify']);
	 Route::post('/verifyOtp',  ['uses'=>'UserController@verifyOtp']);
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
	Route::get('/users/import',  ['as' => 'users.import', 'uses' => 'UserController@userImport']);
	Route::get('/users/profile',  ['as' => 'users.profile', 'uses' => 'UserController@profile']);
	Route::get('/users/settings',  ['as' => 'users.settings', 'uses' => 'UserController@settings']);
	Route::get('/users/vouchers',  ['as' => 'users.voucher', 'uses' => 'UserController@vouchers']);
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
});

Route::group(['prefix' => 'admin',  'middleware' => 'role_or_permission:Administrator'], function(){
	Route::get('/booking/{id}/user','BookingController@userDetail');
	//driver driver/edit
	Route::get('/drivers',  ['as'=>'users.drivers','uses'=>'UserController@driver']);
	Route::post('/driver/make_driver_logout',  ['as'=>'driver.make_driver_logout','uses'=>'UserController@make_driver_logout']);
	Route::get('driver/edit/{id}','UserController@editDriver');
	Route::match(['put', 'patch'],'driver/update/{id}','UserController@updateDriver');
	Route::get('driver/create','UserController@createDriver');
	
	Route::get('driver/{id}','UserController@showDriver')->name('showDriver');
	Route::match(['put', 'patch'], '/users/storeImport',['as'=>'users.storeImport','uses'=>'UserController@storeImport']);
	

	Route::resources(['users'=>'UserController','category'=>'CategoryController','payment-method'=>'PaymentManagementController','admin-control'=>'AdminControlController','contact-support'=>'ContactSupportController','notifications'=>'NotificationController','social-media-setting'=>'SettingController','company'=>'CompanyController','vehicle'=>'VehicleController','vehicle-type'=>'VehicleTypeController','vouchers-offers'=>'VoucherController','promotion'=>'PromotionController','rides'=>'RideController']);
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
	Route::get('/rides','Company\RidesController@index')->name('company.rides');
	Route::delete('ride/delete_multiple','Company\RidesController@delete_multiple')->name('company.rides.delete_multiple');
	Route::get('rides/{id}','Company\RidesController@show')->name('company.rides.show');
	Route::delete('rides/{id}','Company\RidesController@destroy')->name('company.rides.destroy');
	Route::get('settings','CompanyController@settings')->name('company.settings');
	Route::resource('managers','Company\ManagersController')->middleware('can:isCompany');
});
Route::resource('company-users','Company\UsersController')->middleware(['auth','role_or_permission:Company']);

Route::group(['prefix' => 'admin',  'middleware' => 'role_or_permission:Company|Administrator'], function(){
		Route::resources(['users'=>'UserController']);
		//Route::get('{id}/{type}/user/','BookingController@bookingUserDetail');
});


Route::get('/book-ride','RideManagementController@bookRide');
Route::group([ 'middleware' => 'auth'], function(){
	// Route::post('/userCreate',  ['as'=>'userCreate','uses'=>'UserController@userCreate']);
});

Route::get('company-login',  ['as'=>'company_login','uses'=>'Company\LoginController@login']);