<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Payment routes
Route::get('payment', array(
'as' => 'payment',
'uses' => 'PaypalController@postPayment',
));

// this is after make the payment, PayPal redirect back to your site
Route::get('payment/status', array(
    'as' => 'payment.status',
    'uses' => 'PaypalController@getPaymentStatus',
));

//Authenticating Route
Route::auth();

//Send Notification route
Route::get('/sendNotification', ['as' => 'send_notification', 'uses' => 'HomeController@sendNotifications']);
Route::get('/sendEmailNotification', ['as' => 'send_email_notification', 'uses' => 'HomeController@sendEmailNotifications']);
Route::post('/verify', ['as' => 'verify_code', 'uses' => 'HomeController@verifyMobile']);
Route::post('/verify_email', ['as' => 'verify_email_code', 'uses' => 'HomeController@verifyEmail']);

//Howme page route.
Route::get('/home', 'HomeController@index');
