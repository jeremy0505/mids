<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Plan;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/login_check', [App\Http\Controllers\HomeController::class, 'login_check'])->name('home');
Route::get('/prop_wizard', [App\Http\Controllers\HomeController::class, 'prop_wizard'])->name('prop_wizard');
Route::get('/dev_auth_get_plans', [App\Http\Controllers\PlansController::class, 'fn_plan'])->name('plans');



// this route is to show details of all "plans""
//
// ** UNAUTHENTICATED **

Route::get('/dev_get_plans', function (Plan $plan) {
    return view('plans', ['plans' =>  Plan::all()]);
});



Route::view('/dev_view_plans', 'plans', ['plans' => Plan::all()]);


Route::view('/mids_home', 'mids_home', ['plans' => Plan::all()]);


//---------------------------------
// examples / test routes

use Illuminate\Http\Request;
Route::get('/request', function (Request $request) {
    // ...
    dd($request);
});



Route::get('/user/{id}', function ($id) {
    return 'User '.$id;
});



Route::get('/dev_register', function (Plan $plan) {
    return view('auth/register', ['plans' =>  Plan::all()]);
});


//-----------------------------------



