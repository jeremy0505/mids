<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Plan;
use App\Models\MyPropertyRoom;


//
// trace all DB queries
//
use Illuminate\Support\Facades\Route;
DB::listen(function ($query)
{
    logger($query->sql,$query->bindings); });
//



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

Route::get('/home', 
           [App\Http\Controllers\HomeController::class,
           'index'])->name('home');

Route::get('/login_check', 
           [App\Http\Controllers\HomeController::class, 
           'login_check'])->name('home');

Route::get('/prop_wizard',        
        [App\Http\Controllers\PropertyController::class, 
        'prop_wiz1'])->name('prop_wizard');


Route::put('/storeproperty', 
        [App\Http\Controllers\PropertyController::class, 
        'prop_wiz1_db'])->name('prwiz1');

Route::put('/storenumrooms', 
        [App\Http\Controllers\PropertyController::class, 
        'prop_wiz2_db'])->name('prwiz2',);

Route::put('/storeroomnames', 
        [App\Http\Controllers\PropertyController::class, 
        'prop_wiz3_db'])->name('prwiz3',);


Route::put('/storeroomitems', 
        [App\Http\Controllers\PropertyController::class, 
        'prop_wiz4_db'])->name('prwiz4',);


Route::get('/roomwiz/{id}', function ($property_room_id) {
            return view('mids_prop_wiz4',
                        ['rmid' => $property_room_id]);
        });


Route::get('/wizmaster/{id}', function ($property_id) {
            return view('mids_prop_wiz_room_master',['property_id',session('g_my_property_id')]);
            // pass in rooms and #items in each room
                       // ['property_id',$rooms = MyPropertyRoom::all()->where('my_property_id', session('g_my_property_id'));
            //);
        });




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



