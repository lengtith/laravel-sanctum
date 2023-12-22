<?php

use App\Http\Controllers\APIs\V1\AuthController;
use App\Http\Controllers\APIs\V1\CustomerController;
use App\Http\Controllers\APIs\V1\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// API V1 routes
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\APIs\V1', 'middleware' => 'auth:sanctum'], function () {
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('invoices', InvoiceController::class);

    Route::post('invoices/bulk', [InvoiceController::class, 'bulkStore']);

    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('profile', [AuthController::class, 'profile']);
});
