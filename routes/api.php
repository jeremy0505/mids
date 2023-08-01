<?php

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MyItemController;
use App\Http\Controllers\TextInController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// >----------------------
// Sanctum / API dev work


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logoff', [AuthController::class, 'logoff']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/item_summary_counts', [MyItemController::class, 'item_summary_counts']);
    Route::post('/textin', [TextInController::class, 'textin']);
    Route::post('/makesampleitems', [MyItemController::class, 'createsample']);
    Route::get('myitems/{systype}', function ($systype) {
        return MyItemController::item_basic_data($systype);
    });
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/perdu/log', [AuthController::class, 'perdulog']);


// END
// <----------------------
