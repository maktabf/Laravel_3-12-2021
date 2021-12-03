<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

Route::group(['middleware' => 'auth.basic'], function () {
    Route::get('/user/token', function (Request $request) {
        $token = Str::random(60);
        Auth::user()->update(['api_token' => hash('sha256', $token)]);
        return response()->json(['token' => $token]);
    });
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('/posts', PostController::class);
});


Route::apiResource('/car', CarController::class);
