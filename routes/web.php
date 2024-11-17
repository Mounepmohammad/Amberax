<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\admin_wep_controller;
use App\Http\Controllers\login_wep_controller;
use App\Http\Controllers\accountent_wep_controller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
})->name('start');




// Route::get('dash', function () {
//     return view('admin.dashboard');
// })->name('dash');


Route::get('add-provider1', function () {
    return view('admin.add_provider');
})->name('add-provider1');


Route::post('/login', [login_wep_controller::class, 'login'])->name('login');
Route::get('/dash', [admin_wep_controller::class, 'dash'])->name('dash');

Route::get('/data-provider', [admin_wep_controller::class, 'providers'])->name('data-provider');
Route::post('/delete-provider', [admin_wep_controller::class, 'delete_provider'])->name('delete-provider');
Route::get('/detailes-provider/{id}', [admin_wep_controller::class, 'provider_detailes'])->name('detailes-provider');
Route::get('/edit-provider/{id}', [admin_wep_controller::class, 'edit_provider'])->name('edit-provider');
Route::post('/update-provider/{id}', [admin_wep_controller::class, 'update_provider'])->name('update-provider');
Route::post('/add-provider', [admin_wep_controller::class, 'add_provider'])->name('add-provider');
Route::get('/data-employees/{id}', [admin_wep_controller::class, 'employes'])->name('data-employees');
Route::get('/data-subscribers/{id}', [admin_wep_controller::class, 'clients'])->name('data-subscribers');
Route::get('/invioces-paid/{id}', [admin_wep_controller::class, 'paid_bill'])->name('invioces-paid');
Route::get('/invioces-not-paid/{id}', [admin_wep_controller::class, 'not_paid_bill'])->name('invioces-not-paid');



Route::get('/accountant/{id}', [accountent_wep_controller::class, 'accountant'])->name('accountant');
Route::get('/clients/{id}', [accountent_wep_controller::class, 'clients'])->name('clients');
Route::get('/bills/{id}', [accountent_wep_controller::class, 'bills'])->name('bills');
Route::get('/client_bills/{id}', [accountent_wep_controller::class, 'client_bills'])->name('client_bills');
Route::get('/pay_bill/{id}', [accountent_wep_controller::class, 'pay_bill'])->name('pay_bill');








// {{-- <div class="col-6 " ><a href="{{route('invoices-paid')}}" class="w-100 flex-fill px-5 btn btn-success 3">الفواتير المدفوعة </a></div>
//     <div class="col-6 "><a href="{{route('invoices-not-paid')}}" class="w-100 flex-fill px-5 btn btn-danger ">الفواتير الغير المدفوعة</a></div> --}}


// Route::get('data-employees', function () {
//     return view('admin.data.data_employees');
// })->name('data-employees');


// Route::get('data-subscribers', function () {
//     return view('admin.data.data_subscriber');
// })->name('data-subscribers');




// Route::get('edit-provider', function () {
//     return view('admin.edit_detailes_provider');
// })->name('edit-provider');

// Route::get('detailes-provider', function () {
//     return view('admin.detailes_provider');
// })->name('detailes-provider');


// Route::get('invioces-paid', function () {
//     return view('admin.invioces_paid');
// })->name('invoices-paid');


// Route::get('invioces-not-paid', function () {
//     return view('admin.invioces_not_paid');
// })->name('invoices-not-paid');



// Route::get('accountant', function () {
//     return view('accountant.accountant');
// })->name('accountant');

Route::get('inovices_accountant', function () {
    return view('accountant.inovices_accountant');
})->name('inovices_accountant');


Route::get('invoices_subscriber', function () {
    return view('accountant.invoices_subscriber');
})->name('invoices_subscriber');

Route::get('subscribers', function () {
    return view('accountant.subscribers');
})->name('subscribers');



// Route::get('login', function () {
//     return view('login');
// })->name('login');
