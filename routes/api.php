<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\login_controller;
use App\Http\Controllers\user1_controller;
use App\Http\Controllers\user2_controller;
use App\Http\Controllers\admin_controller;
use App\Http\Controllers\provider_controller;
use App\Http\Controllers\collector_controller;
use App\Http\Controllers\maintenance_controller;
use App\Http\Controllers\accountent_controller;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    // 'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [user1_controller::class, 'register']);
    Route::post('/logout', [user1_controller::class, 'logout']);
    Route::get('/profile', [user1_controller::class, 'profile']);
    Route::post('/update', [user1_controller::class, 'update']);
});

Route::group([
    // 'middleware' => 'api',
    'prefix' => 'user'
], function ($router) {
    Route::post('/providers', [user2_controller::class, 'providers']);
    Route::post('/search', [user2_controller::class, 'search']);
    Route::post('/subscribe', [user2_controller::class, 'subscribe']);

    Route::post('/my_complaints', [user2_controller::class, 'my_complaints']);
    Route::post('/provider_complaints', [user2_controller::class, 'provider_complaints']);
    Route::post('/add_complaint', [user2_controller::class, 'add_complaint']);
    Route::post('/update_complaint', [user2_controller::class, 'update_complaint']);
    Route::post('/delete_complaint', [user2_controller::class, 'delete_complaint']);

    Route::post('/provider_offers', [user2_controller::class, 'provider_offers']);

    Route::post('/my_bills', [user2_controller::class, 'my_bills']);

});

Route::group([
    'prefix' => 'admin'
], function ($router) {
    Route::post('/providers', [admin_controller::class, 'providers']);
    Route::post('/add_provider', [admin_controller::class, 'add_provider']);
    Route::post('/update_provider', [admin_controller::class, 'update_provider']);
    Route::post('/delete_provider', [admin_controller::class, 'delete_provider']);


});
Route::group([
    'prefix' => 'provider'
], function ($router) {

    Route::post('/complete_profile', [provider_controller::class, 'complete_profile']);

    Route::post('/employes', [provider_controller::class, 'employes']);
    Route::post('/add_collector', [provider_controller::class, 'add_collector']);
    Route::post('/add_accountent', [provider_controller::class, 'add_accountent']);
    Route::post('/add_maintenance', [provider_controller::class, 'add_maintenance']);
    Route::post('/update_employe', [provider_controller::class, 'update_employe']);
    Route::post('/delete_employe', [provider_controller::class, 'delete_employe']);

    Route::post('/users_request', [provider_controller::class, 'users_request']);
    Route::post('/complete_request', [provider_controller::class, 'complete_request']);
    Route::post('/update_client', [provider_controller::class, 'update_client']);
    Route::post('/delete_client', [provider_controller::class, 'delete_client']);
    Route::post('/clients', [provider_controller::class, 'clients']);


    Route::post('/complaints', [provider_controller::class, 'complaints']);
    Route::post('/add_response', [provider_controller::class, 'add_response']);
    Route::post('/delete_complaint', [provider_controller::class, 'delete_complaint']);
    Route::post('/offers', [provider_controller::class, 'offers']);
    Route::post('/add_offer', [provider_controller::class, 'add_offer']);
    Route::post('/update_offer', [provider_controller::class, 'update_offer']);
    Route::post('/delete_offer', [provider_controller::class, 'delete_offer']);

    Route::post('/my_bills', [provider_controller::class, 'my_bills']);
    Route::post('/bills_value', [provider_controller::class, 'bills_value']);


});

Route::group([
    'prefix' => 'collector'
], function ($router) {
    Route::post('/clients', [collector_controller::class, 'clients']);
    Route::post('/search', [collector_controller::class, 'search']);
    Route::post('/client_bills', [collector_controller::class, 'client_bills']);
    Route::post('/add_bill', [collector_controller::class, 'add_bill']);
    Route::post('/my_bills', [collector_controller::class, 'my_bills']);
    Route::post('/update_bill', [collector_controller::class, 'update_bill']);

    Route::post('/my_company', [collector_controller::class, 'my_company']);

});

Route::group([
    'prefix' => 'maintenance'
], function ($router) {
    Route::post('/clients', [maintenance_controller::class, 'clients']);
    Route::post('/search', [maintenance_controller::class, 'search']);
    Route::post('/provider_request', [maintenance_controller::class, 'provider_request']);
    Route::post('/confirm_request', [maintenance_controller::class, 'confirm_request']);

    Route::post('/my_company', [maintenance_controller::class, 'my_company']);


});

Route::group([
    'prefix' => 'accountent'
], function ($router) {
    Route::post('/clients', [accountent_controller::class, 'clients']);
    Route::post('/search', [accountent_controller::class, 'search']);
    Route::post('/client_bills', [accountent_controller::class, 'client_bills']);
    Route::post('/pay_bill', [accountent_controller::class, 'pay_bill']);
    Route::post('/my_bills', [accountent_controller::class, 'my_bills']);


});

Route::group([
    'prefix' => 'all'
], function ($router) {
    Route::post('/login', [login_controller::class, 'login']);

});
