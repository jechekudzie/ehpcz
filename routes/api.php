<?php

use App\Http\Controllers\ApiController;
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

//cities index
Route::get('/cities/{province_id}', [ApiController::class, 'index'])->name('cities.index');
Route::get('/qualifications/{profession_id}', [ApiController::class, 'qualifications'])->name('qualifications');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
