<?php

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\MyItem;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// >----------------------
// Sanctum / API dev work


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logoff', [AuthController::class, 'logoff']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/textin', [AuthController::class, 'textin']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::get('myitems/{systype}', function ($systype) {

    // If the Content-Type and Accept headers are set to 'application/json', 
    // this will return a JSON structure. This will be cleaned up later.

    return MyItem::item_basic_data($systype);
})->middleware('auth:sanctum');

// END
// <----------------------
