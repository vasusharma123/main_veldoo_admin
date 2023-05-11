<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Config::set('limit_api', 20);

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

#GUEST GROUP
Route::group(['namespace' => 'API'], function(){
	// Route::post('register_or_update', 'UserController@register_or_update');
	Route::post('register', 'UserController@register');
	Route::post('login', 'UserController@login');
	Route::post('driverLogin', 'UserController@driverLogin');
	Route::post('social_login', 'UserController@social_login');
	Route::post('verifyOtp', 'UserController@verifyOtp');
	Route::post('resend_otp', 'UserController@resendOtp');
	Route::get('driverClassList', 'UserController@driverClassList');
	Route::get('complainedTypes', 'UserController@complainedTypes');
	Route::get('vehicleTypes', 'UserController@vehicleTypes');
	Route::get('rideTypes', 'UserController@rideTypes');
	Route::post('forgot_password', 'UserController@forgotPassword');
	Route::post('pages', 'UserController@pages');
	Route::post('page', 'PageController@page');
	Route::post('subjects', 'CategoryController@subjectsList');
	Route::post('check_user_by_phone', 'UserController@checkRegisteredUser');
	Route::post('verify_user_registered', 'UserController@verify_user_registered');
	Route::get('rideAssignstoNext', 'UserController@rideAssignstoNext');
	Route::get('expense/types', 'ExpenseController@types');
	Route::post('users/set-users-password', 'UserController@setUsersPassword');
});

#CATEGORY GROUP
Route::group(['prefix' => 'category','namespace' => 'API','middleware' => ['auth:api','driver_still_active']], function(){
	Route::post('add_item', 'CategoryController@addItem');
	Route::post('categories_list', 'CategoryController@categoriesList');
	Route::post('items_list', 'CategoryController@itemsList');
	Route::post('update_item', 'CategoryController@updateItem');
	Route::post('delete_item', 'CategoryController@deleteItem');
	Route::post('search_items', 'CategoryController@searchItems');
	Route::post('item_detail', 'CategoryController@itemDetail');
	Route::post('driver_items_list', 'CategoryController@driverItemsList');
});

#USER GROUP
Route::group(['prefix' => 'user','namespace' => 'API','middleware' => ['auth:api','driver_still_active']], function(){
	Route::post('change_password', 'UserController@change_password');
	Route::post('reset_password', 'UserController@reset_password');
	Route::post('admin_contact', 'UserController@adminContact');
	Route::post('logout', 'UserController@logout');
	
	Route::post('get_notification', 'UserController@get_notification');
	Route::post('get_users', 'UserController@get_users');
	Route::post('get_users_by_id', 'UserController@getUserById');
	Route::post('details', 'UserController@details');
	Route::get('details', 'UserController@details');
	Route::post('ad_click', 'UserController@adClick');
	Route::post('driver_list', 'UserController@driver_list');
	Route::post('newRides', 'UserController@newRides');
	Route::post('menu_list', 'UserController@menu_list');
	Route::post('add_fav', 'UserController@addFav');
	Route::post('addPlace', 'UserController@addPlace'); 
	Route::post('addCard', 'UserController@addCard'); 
	Route::post('addPersonal', 'UserController@addPersonal'); 
	Route::post('addVehicle', 'UserController@addVehicle'); 
	Route::post('updateVehicle', 'UserController@updateVehicle'); 
	Route::post('rideStatusChange', 'UserController@rideStatusChange'); 
	Route::post('scheduleRide', 'UserController@scheduleRide'); 
	//Route::post('shareRide', 'UserController@shareRide'); 
	Route::post('driverDetail', 'UserController@driverDetail'); 
	Route::post('customerDetail', 'UserController@customerDetail'); 
	// Route::post('phoneVerify', 'UserController@phoneVerify'); 
	Route::post('update_profile', 'UserController@update_profile'); 
	Route::post('add_cart', 'UserController@addCart');
	Route::post('add_booking', 'UserController@addBooking');
	Route::get('cart_list', 'UserController@cart_list');
	Route::post('fav_list', 'UserController@fav_list');
	Route::get('fav_list', 'UserController@fav_list');
	Route::get('place_list', 'UserController@place_list');
	Route::get('notification_list', 'UserController@notification_list');
	Route::get('notificationRead', 'UserController@notificationRead');
	Route::get('card_list', 'UserController@card_list');
	Route::post('price_list', 'UserController@price_list');
	Route::post('contactAdmin', 'UserController@contactAdmin');
	Route::post('raisecomplain', 'UserController@raisecomplain');
	Route::post('check_promo', 'UserController@checkPromo');
	Route::post('deletePlace', 'UserController@deletePlace');
	Route::post('deleteCard', 'UserController@deleteCard');
	Route::post('addwallet', 'UserController@addwallet');
	
	Route::post('giveRating', 'UserController@giveRating');
	Route::post('userRideList', 'UserController@userRideList');
	Route::post('invoice', 'UserController@invoice');
	Route::post('updateBankdetail', 'UserController@updateBankdetail');
	
	Route::get('drivercompletedRide', 'UserController@drivercompleted_ride');
	Route::get('drivercancelledRide', 'UserController@drivercancelled_ride');
	Route::get('onlineDrivers', 'UserController@onlineDrivers');
	//
	Route::post('instant_ride', 'UserController@instantRide');
	Route::post('share_ride', 'UserController@sharingRide');
	Route::post('create_trip', 'UserController@createTrip');
	Route::post('rides_for_sharing', 'UserController@rideForSharing');
	Route::post('ride_detail', 'UserController@rideDetail');
	Route::post('cancel_ride', 'UserController@cancelRide');
	Route::post('addLocation', 'UserController@addLocation');
	Route::get('getLocations', 'UserController@getLocations');
	Route::post('ride_list','user\RideController@ride_list');
	Route::post('add_stopover', 'UserController@addStopover');
	Route::post('sendRidetoMaster', 'UserController@sendRidetoMaster');
	
	Route::post('update_user_data', 'UserController@updateUserData');
	Route::post('ride_edit', 'UserController@rideEdit');
	Route::post('joinRideList', 'UserController@joinRideList');
	Route::post('joinRide', 'UserController@joinRide');
	Route::post('joinRideData', 'UserController@joinRideData');
	Route::post('homedriverList', 'UserController@homedriverList');
	Route::post('getVouchers', 'UserController@getVouchers');

	Route::get('latest_ride_detail','RideController@latest_ride_detail');
	Route::post('ride/detail','user\RideController@ride_detail');
	Route::post('ride/status_change','user\RideController@statusChange');

	Route::post('get_user_by_phone','user\ProfileController@getUserByPhone');
	Route::get('my_profile','user\ProfileController@my_profile');
	Route::post('delete_account', 'user\ProfileController@destroy');
	Route::post('ride/update_address', 'RideController@update_ride_address');
});
Route::group(['prefix' => 'driver', 'namespace' => 'API', 'middleware' => ['auth:api']], function () {
	Route::group(['middleware' => ['driver_still_active']], function () {
		Route::post('change_password', 'UserController@change_password');
		Route::get('car_list', 'UserController@carList');
		Route::post('update_car', 'UserController@updateCar');
		Route::post('set_password', 'UserController@setPassword');
		Route::post('save_selected_car', 'UserController@saveSelectedCar');
		Route::get('get_current_user_type', 'UserController@getCurrentUserType');
		Route::post('bookRide', 'UserController@bookRide');
		Route::get('get_saved_location', 'UserController@getSavedLocation');
		Route::post('change_default_home_work_location', 'UserController@changeDefaultHomeWorkLocation');
		Route::post('complete_ride', 'UserController@completeRide');
		Route::post('rate_ride', 'UserController@rateRide');
		Route::post('accept_reject_ride', 'UserController@acceptRejectRide');
		Route::post('payment_received', 'UserController@paymentReceived');
		Route::post('start_instant_ride', 'UserController@startInstantRide');
		Route::get('get_promotions', 'UserController@getPromotion');
		Route::post('get_promotions', 'UserController@getPromotion');
		Route::post('get_user_by_phone', 'UserController@getUserByPhone');
		Route::post('get_user_info_by_id', 'UserController@getUserInfoById');
		Route::post('ride_list', 'RideController@RideList');
		Route::post('save_user_data', 'UserController@saveUserData');

		Route::post('addLocation', 'UserController@addLocation');
		Route::get('getLocations', 'UserController@getLocations');
		Route::post('driverlistforMaster', 'UserController@driverlistforMaster');
		Route::post('assigndrivertoRide', 'UserController@assigndrivertoRide');
		Route::post('ride_edit', 'UserController@rideEdit');
		Route::post('createRideDriver', 'UserController@createRideDriver');
		Route::post('scheduleRideList', 'UserController@scheduleRideList');
		Route::post('userSearchList', 'UserController@userSearchList');
		Route::post('unassigndrivertoRide', 'UserController@unassigndrivertoRide');
		Route::post('earningDetail', 'UserController@earning_detail');
		Route::post('waitingstatuschange', 'UserController@waitingstatuschange');
		Route::post('joinRideData', 'UserController@joinRideData');
		Route::post('usermilecheck', 'UserController@usermilecheck');
		Route::post('user_invoice_status', 'UserController@getInvoiceUserStatus');
		Route::get('all_drivers', 'UserController@all_drivers');
		Route::get('still_active_notification_response', 'DriverActivityController@still_active_notification_response');
		Route::get('rides/upcoming_rides_count', 'RideController@upcoming_rides_count');
		Route::post('rides/unassign_current_ride', 'RideController@unassign_current_ride');
		Route::post('calendarViewRides', 'RideController@calendarViewRides');
		Route::post('ride/delete', 'RideController@delete');
		Route::post('calendarViewRidesDateBase', 'RideController@calendarViewRidesDateBase');
		Route::post('calendarViewRidesUpDown', 'RideController@calendarViewRidesUpDown');
		Route::post('calendarBasedRides', 'RideController@calendarBasedRides');
		Route::post('cancel_ride', 'RideController@cancel_ride');
		
	});
	Route::post('driverUpdateLocation', 'RideController@driverUpdateLocation');
});
#COMPANY GROUP
Route::get('company/list', 'API\CompanyController@index');
Route::get('company/list_data', 'API\CompanyController@list_data');


Route::get('common', 'API\UserController@common');
Route::get('guest-test', 'API\UserController@guestTest');
Route::post('push', 'API\UserController@push');
Route::post('send_otp', 'API\UserController@sendOtp');
Route::post('otp_verify', 'API\UserController@otpVerify');
Route::post('driverVerifyOtp', 'API\UserController@driverVerifyOtp');
// Route::get('note/{slug}', 'API\TopicController@note');

Route::post('push2', 'API\UserController@push2');
Route::post('categories', 'API\UserController@categories');
Route::post('forgot/password', 'API\ForgotPasswordController')->name('forgot.password');

Route::group(['namespace' => 'API', 'prefix' => 'user_web'], function () {
	Route::post('book_ride', 'UserWebController@book_ride');
	Route::post('create_ride_driver', 'UserWebController@create_ride_driver');
});
Route::group(['namespace' => 'API','middleware' => ['auth:api','driver_still_active']], function () {
	Route::get('settings', 'UserController@settings');
	Route::post('expense/add', 'ExpenseController@add');
	Route::post('expense/list', 'ExpenseController@list');
	Route::get('expense/my_rides', 'ExpenseController@my_rides');
	Route::get('notification/last_unseen', 'NotificationController@last_unseen');
});

//TOPIC GROUP
// Route::group(['prefix' => 'topic','namespace' => 'API','middleware' => 'auth:api'], function(){
// // Route::group(['prefix' => 'topic','namespace' => 'API'], function(){
// 	Route::post('all', ['as'=>'topic.all','uses'=>'TopicController@all']);
// 	// Route::get('all', ['as'=>'topic.all','uses'=>'TopicController@all']);
// 	Route::post('comments', ['as'=>'topic.comments','uses'=>'TopicController@comments']);
// 	Route::post('follow', 'TopicController@follow');
// 	Route::post('followers', 'TopicController@followers');
// 	Route::post('detail', 'TopicController@detail');
// 	Route::post('create_or_update', 'TopicController@create_or_update');
// 	Route::post('comment', 'TopicController@comment');
// 	Route::post('report', 'TopicController@report');
// 	Route::post('push', 'TopicController@push');
// 	Route::post('like', 'TopicController@like');
// 	Route::post('comment_report', 'TopicController@CommentReport');
// 	Route::post('comment_like', 'TopicController@commentLike');
// 	Route::post('reply', 'TopicController@reply');
// 	Route::post('replies', 'TopicController@replies');

// });