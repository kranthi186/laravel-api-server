<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/users', 'Admin\UserController@apiUsers');
});

Route::post('/login', 'Api\AuthenticateController@login')->name('api.login');

Route::post('/featured_retailers', 'Api\UserApiController@featuredRetailers');
Route::post('/retailers', 'Api\UserApiController@retailers');
Route::post('/brands', 'Api\UserApiController@brands');

Route::post('/retailer/{user_id}', 'Api\UserApiController@retailer');
Route::post('/brand/{user_id}', 'Api\UserApiController@brand');
Route::post('/products/{user_id}', 'Api\UserApiController@fetchProducts');

Route::post('/product_reviews/{product_id}', 'Api\UserApiController@productReviews');
Route::post('/product/{product_id}', 'Api\UserApiController@fetchProduct');
Route::post('/retailer_product/{connection_id}', 'Api\UserApiController@fetchRetailerProduct');

Route::post('/add_retailer_review', 'Api\UserApiController@addRetailerReview');
Route::post('/add_product_review', 'Api\UserApiController@addProductReview');

Route::post('/add_consumer', 'Api\UserApiController@addConsumer');

Route::post('/discovery_products', 'Api\UserApiController@discoveryProducts');
Route::post('/add_puff', 'Api\UserApiController@addPuff');
Route::post('/remove_puff', 'Api\UserApiController@removePuff');

Route::post('/match_result', 'Api\UserApiController@matchResult');

Route::post('/available_retailers', 'Api\UserApiController@availableRetailers');

Route::post('/recent_news', 'Api\UserApiController@recentNews');

Route::post('/nearby', 'Api\UserApiController@nearbyProducts');

Route::post('/get_auth', 'Api\UserApiController@getAuth');
Route::post('/valid_username', 'Api\UserApiController@isValidUsername');
Route::post('/valid_email', 'Api\UserApiController@isValidEmail');
