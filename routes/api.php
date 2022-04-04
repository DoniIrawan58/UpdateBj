<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UpdateController;

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

Route::controller(UpdateController::class)->group(function () {
    Route::get('/update', 'index');
    Route::get('/update/{id}', 'index');
    Route::post('/update', 'store');
    Route::post('/update/{id}', 'destroy');
    Route::get('/update/recent', 'updateList');

});
