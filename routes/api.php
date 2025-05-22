<?php


use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\Customer\OfferController;
//use App\Http\Controllers\Api\SupermarketController;
//use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Customer\ProductController;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Api\Customer\AuthController;
use App\Http\Controllers\Api\Customer\SuperMarketController;
use App\Http\Controllers\Api\Customer\OrderController;
use App\Http\Controllers\Api\Customer\SupermarketBankAccountController;

use App\Http\Controllers\Api\Customer\FavoriteController;
use App\Http\Controllers\Api\Customer\CartController;
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





Route::prefix('customer')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('profile', [AuthController::class, 'profile']);
    });
});









Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{id}/products', [CategoryController::class, 'productsByCategory']);








Route::get('/customer/supermarkets', [SuperMarketController::class, 'index']);


Route::get('/customer/products', [ProductController::class, 'getAllProducts']);

Route::prefix('customer')->group(function () {
    Route::get('products', [ProductController::class, 'getAllProducts']);
    Route::get('supermarkets/{id}/products', [ProductController::class, 'getProductsBySupermarket']);
    // ... أي routes أخرى
});


Route::get('customer/supermarkets/{id}/products', [SupermarketController::class, 'products']);
Route::get('categories/{id}/products', [CategoryController::class, 'productsByCategory']);
Route::get('customer/supermarkets/{id}', [SupermarketController::class, 'show']);

Route::get('customer/supermarkets/{id}/offers', [OfferController::class, 'offersBySupermarket']);


Route::prefix('customer')->group(function () {
 
    Route::get('products/barcode/{barcode}/compare', 
                [ProductController::class, 'comparePricesByBarcode']);
});







Route::apiResource('/customer/offers', OfferController::class);




Route::middleware('auth:sanctum')
     ->prefix('customer')
     ->group(function () {
         // 1. جلب محتويات السلة
         Route::get('cart', [CartController::class, 'index']);

         // 2. إضافة عنصر إلى السلة
         Route::post('cart', [CartController::class, 'store']);

         // 3. تعديل كمية عنصر محدد
         Route::put('cart/{id}', [CartController::class, 'update']);

         // 4. إزالة عنصر واحد
         Route::delete('cart/{id}', [CartController::class, 'destroy']);

         // 5. تفريغ كامل السلة
        Route::delete('cart/clear/{supermarket_id}', [CartController::class, 'clearSupermarket']);

     });



Route::any('customer/cart/clear', [CartController::class, 'clear']);


Route::middleware('auth:sanctum')->group(function(){
  Route::get   ('favorites',             [FavoriteController::class,'index']);
  Route::post  ('favorites',             [FavoriteController::class,'store']);
  Route::delete('favorites/{product_id}',[FavoriteController::class,'destroy']);
});






Route::middleware('auth:sanctum')->group(function () {
    Route::post('/orders', [OrderController::class, 'createOrder']); // طلب جديد متعدد السوبرماركت
    Route::post('/orders/{order}/deposit', [OrderController::class, 'uploadDepositReceipt']); // رفع سند الإيداع
    Route::get('/orders', [OrderController::class, 'getUserOrders']); // كل طلباتي
    Route::get('/orders/{order}', [OrderController::class, 'getOrderDetails']); // تفاصيل الطلب
    Route::put('/orders/{order}/payment', [OrderController::class, 'updatePaymentStatus']); // تأكيد أو رفض الدفع

    // حسابات البنوك
    Route::get('/supermarkets/{id}/bank-accounts', [SupermarketBankAccountController::class, 'getBankAccounts']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/orders', [OrderController::class, 'createOrder']);
});
Route::put('/orders/{order}/cancel', [OrderController::class, 'cancelOrder']);
