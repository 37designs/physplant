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

// Index Controls
Route::get('/', function () {
	// Check if user is logged in.
	if (Auth::check())
	{
		// If so, take to home page
		return redirect('home');
	} else
	{
		// If not, take to login page.
		return redirect('login');
	}
});

// Handle old part order url
Route::get('/{url}', function () {
	return redirect()->route("partsrequest");
})->where('url', '(order|order.php)');

// Login Controls
Route::get('/login', 'LoginController@create')->name('login');
Route::post('/login', 'LoginController@authenticate');
Route::post('/logout', 'LoginController@logout')->name('logout');

// Home Controls
Route::get('/home', 'HomeController@index')->name('home');

// Parts Request Controls
Route::get("/partsrequest", 'PartsRequestController@index')->name('partsrequest');
Route::post("/partsrequest", 'PartsRequestController@store');

// Request Controls
Route::get("/requests", 'RequestController@index')->name('requests');
Route::get("/requests/{id}", 'RequestController@show');
Route::patch("/requests/{id}", 'RequestController@patch');
Route::post("/requests", 'RequestController@post');

// User Settings Controls
Route::get("/settings", 'UserSettingsController@index')->name('settings');
Route::post("/settings", 'UserSettingsController@store');

// Comment Controls
Route::post("/comment/{id}", 'CommentController@store')->name('comment');

// Request Controls
Route::get("/materials", 'MaterialController@index')->name('materials');
Route::get("/materials/{id}", 'MaterialController@show');
Route::patch("/materials/{id}", 'MaterialController@patch');
Route::get("/materialsdata", 'MaterialController@materialsData')->name('materialsdata');

// User Controller
Route::get('/users', 'UserController@index')->name('users');
Route::post('/users/create', 'UserController@store');
Route::patch('/users/{user}', 'UserController@update');

// Tech Controller
Route::get('/techs', 'TechController@index')->name('techs');
Route::post('/techs/create', 'TechController@store');
Route::patch('/techs/{tech}', 'TechController@update');

// All Request Controls
Route::get("/allrequests", 'AllRequestController@index')->name('allrequests');
Route::get("/allrequestsdata", 'AllRequestController@allRequestData')->name('allrequestsdata');
Route::get("/allrequests/{id}", 'AllRequestController@show');

// Received Manager Controls
Route::get("/receivedmanager", 'ReceivedManagerController@index')->name('receivedmanager');
Route::get("/receivedmanager/{id}", 'ReceivedManagerController@show');
Route::patch("/receivedmanager/{id}", 'ReceivedManagerController@patch');

// Checkout Controls
Route::get("/checkout", 'CheckoutController@index')->name('checkout');
Route::put("/checkout", 'CheckoutController@packageInfo');
Route::patch("/checkout", 'CheckoutController@eidInfo');
Route::post("/checkout", 'CheckoutController@post');
Route::post("/checkout/nologin", 'CheckoutController@noLastingLogin')->name('checkoutauth');