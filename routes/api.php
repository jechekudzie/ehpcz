<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ExchangeRateController;
use App\Http\Controllers\FeeItemController;
use App\Http\Controllers\RegistrationRuleController;
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

// In routes/api.php
// Fetch fee items by category
Route::get('/fee-categories/{categoryId}/fee-items', [FeeItemController::class, 'getFeeItemsByCategory']);

// Fetch fee item details including amount
Route::get('/fee-items/{id}/amount', [FeeItemController::class, 'getFeeItemAmount']);

// Fetch fee item by registration rule
Route::get('/registration-rules/{id}/fee-item', [RegistrationRuleController::class, 'getFeeItem']);


// Define the route for getting the active exchange rate
Route::get('/get-active-exchange-rate/{currencyId}', [ExchangeRateController::class, 'getActiveExchangeRate']);

Route::post('/verify-account', [ApiController::class, 'verifyAccount']);

//cities index
Route::get('/cities/{province_id}', [ApiController::class, 'index'])->name('cities.index');
Route::get('/qualifications/{profession_id}', [ApiController::class, 'qualifications'])->name('qualifications');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
