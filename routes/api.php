<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\SupermarketController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Request;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Laravel\Sanctum\Sanctum;
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


Route::prefix('supermarket/{supermarket_id}')->group(function () {
    Route::apiResource('products', ProductController::class);
});


Route::prefix('supermarket/{supermarket_id}')->group(function () {
    Route::apiResource('offers', OfferController::class);
    // لإضافة مسار البحث
    Route::get('offers/search', [OfferController::class, 'search']);
});

Route::apiResource('supermarkets', SupermarketController::class);




Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});






