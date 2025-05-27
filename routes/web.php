<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\SupermarketController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\FoodBasketController;
use App\Http\Controllers\Admin\SupermarketBankAccountController;
use App\Http\Controllers\Admin\SupermarketOrderWebController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GeneralManagement\ReportsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;






Route::get('/Dashborad', [AdminController::class, 'Dashborad']);

// إذا كان المستخدم مسجلاً دخوله، يتم توجيهه إلى لوحة تحكم السوبرماركت
Route::get('/supermarket/{id}/dashboard', function ($id) {
    // التحقق مما إذا كان المستخدم مسجلاً دخوله
    if (Auth::check()) {
        return redirect()->route('Dashborad', ['id' => $id]);
    } else {
        return redirect()->route('login');
    }
})->name('supermarket.dashboard');



// ----------------SupermarketController Route

Route::get('/supermarket/{id}/dashboard', [SupermarketController::class, 'dashboard'])->name('Dashborad');

Route::get('/CreateSupermarket', [SupermarketController::class, 'create']);
Route::post('/supermarket/store', [SupermarketController::class, 'store'])->name('supermarket.store');

// ----------------EndSupermarketController Route


// Route::resource('admin/categories', CategoriesController::class)
//      ->names(['index'=>'admin.categories.index', 'store'=>'admin.categories.store', /* … */]);




Route::get('/register', [AuthController::class, 'showRegister'])->name('show.register');
Route::get('/login', [AuthController::class, 'showLogin'])->name('show.login');

Route::post('/register', [AuthController::class, 'Register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::get('/select_type_of_user', [AuthController::class, 'select_type_of_user']);

Route::get('/view_Setting', [AdminController::class, 'view_Setting']);





// ----------------Product Route

Route::get('/supermarket/{supermarket_id}/view_product', [ProductController::class, 'view_product'])->name('view_product');
Route::post('/supermarket/{supermarket_id}/add_products', [ProductController::class, 'add_products'])->name('add_products');
Route::get('/supermarket/{supermarket_id}/show_Product', [ProductController::class, 'show_Product'])->name('show_product');


Route::get('/delete_product/{id}', [ProductController::class, 'delete_product']);
Route::get('/supermarket/{supermarket_id}/update_product/{product_id}', [ProductController::class, 'update_product'])->name('update_product');
Route::post('/supermarket/{supermarket_id}/update_product_confirm/{product_id}', [ProductController::class, 'update_product_confirm'])->name('update_product_confirm');
Route::get('/search_product', [ProductController::class, 'searchProduct'])->name('search_product');


//-------------------End-- Product Route


Route::get('/supermarket/{supermarket}/food-baskets', [FoodBasketController::class, 'index'])->name('supermarket.food_baskets.index');

Route::get('/supermarket/{supermarket}/food-baskets/create', [FoodBasketController::class, 'create'])->name('supermarket.food_baskets.create');
Route::post('/supermarket/{supermarket}/food-baskets', [FoodBasketController::class, 'store'])->name('supermarket.food_baskets.store');
Route::get('/supermarket/{supermarket}/food-baskets/{foodBasket}', [FoodBasketController::class, 'show'])->name('supermarket.food_baskets.show');
Route::get('/supermarket/{supermarket}/food-baskets/{foodBasket}/edit', [FoodBasketController::class, 'edit'])->name('supermarket.food_baskets.edit');
Route::put('/supermarket/{supermarket}/food-baskets/{foodBasket}', [FoodBasketController::class, 'update'])->name('supermarket.food_baskets.update');
Route::delete('/supermarket/{supermarket}/food-baskets/{foodBasket}', [FoodBasketController::class, 'destroy'])->name('supermarket.food_baskets.destroy');




// -------------------- Offers Route
Route::get('/supermarket/{supermarket_id}/view_offers', [OfferController::class, 'view_offers'])->name('view_offers');
Route::post('/supermarket/{supermarket_id}/add_offers', [OfferController::class, 'add_offers'])->name('add_offers');
Route::get('/supermarket/{supermarket_id}/show_offers', [OfferController::class, 'show_offers'])->name('show_offers');
Route::get('/offers', [OfferController::class, 'searchOffers'])->name('search_offers');
Route::get('/delete_offers/{id}', [OfferController::class, 'delete_offers']);
Route::get('/supermarket/{supermarket_id}/update_offers/{id}', [OfferController::class, 'update_offers'])->name('update_offers');
Route::post('/supermarket/{supermarket_id}/update_offers_confirm/{id}', [OfferController::class, 'update_offers_confirm'])->name('update_offers_confirm');


Route::get('/supermarket/{supermarket_id}/offers_process', [OfferController::class, 'offers_process'])->name('offers_process');







Route::get('/offers_process/{supermarket_id}', [OfferController::class, 'offers_process'])->name('offers_process');
Route::get('/Show_offersProces/{supermarket_id}', [OfferController::class, 'Show_offersProces'])->name('Show_offersProces');
Route::post('/process_offer_image/{supermarket_id}', [OfferController::class, 'process_offer_image'])->name('process_offer_image');
Route::get('/edit_ai_offer/{supermarket_id}/{id}', [OfferController::class, 'edit_ai_offer'])->name('edit_ai_offer');
Route::post('/update_ai_offer/{supermarket_id}/{id}', [OfferController::class, 'update_ai_offer'])->name('update_ai_offer');
//---------------------- End Offers Route





Route::get('/view_Setting', [AdminController::class, 'view_Setting']);


// Route::get('/view_order', [AdminController::class, 'view_order']);
// Route::get('/orders', [AdminController::class, 'orders']);

Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.form');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::get('/about_us', [AdminController::class, 'about_us'])->name('about_us');

Route::get('/Terms', [AdminController::class, 'terms'])->name('Terms');
Route::get('/members', [AdminController::class, 'members'])->name('members');

//Route::get('/login', [logincontroller::class, 'showLoginForm'])->name('login');
//Route::post('/login', [logincontroller::class, 'login']);
//Route::post('/logout', [logincontroller::class, 'logout'])->name('logout');


Route::get('/landing', function () {
    return response()->file(public_path('index.html'));
});




Route::get('/', function () {
    return view('home');
})->name('home');;

Route::view('/terms', 'terms')->name('terms');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/privacy', 'privacy')->name('privacy');





//Route::get('/admin/supermarket/{id}', [ProfileController::class, 'edit'])
    //->name('admin.supermarket.edit');

    Route::middleware('auth')->group(function () {
        Route::get('/supermarket/{id}/profile', [ProfileController::class, 'edit'])->name('admin.supermarket.edit');
       
        Route::put('/supermarket/{id}/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');

    });

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('bank-account/create/{supermarket}', [SupermarketBankAccountController::class, 'create'])->name('bank-account.create');
    Route::post('bank-account/store', [SupermarketBankAccountController::class, 'store'])->name('bank-account.store');
    // هذا هو الراوت الصحيح:
    Route::get('bank-account/inline-edit/{supermarket}/{account}', [SupermarketBankAccountController::class, 'editBankAccount'])->name('bank-account.inlineEdit');
    Route::put('bank-account/update/{id}', [SupermarketBankAccountController::class, 'update'])->name('bank-account.update');
    Route::delete('bank-account/destroy/{id}', [SupermarketBankAccountController::class, 'destroy'])->name('bank-account.destroy');
});



  









    // مسارات استيراد المنتجات
Route::get('admin/import-products/{supermarket_id}', [ProductController::class, 'importProductsForm'])->name('import_products_form');
Route::post('admin/import-products/{supermarket_id}', [ProductController::class, 'importProducts'])->name('import_products');
Route::get('admin/download-excel-template/{supermarket_id}', [ProductController::class, 'downloadExcelTemplate'])->name('download_excel_template');



Route::middleware(['auth',])
     ->prefix('supermarket/{supermarket_id}')
     ->name('supermarket.')
     ->group(function(){
         Route::get('orders',                     [SupermarketOrderWebController::class,'index'])->name('orders.index');
         Route::get('orders/{orderId}',           [SupermarketOrderWebController::class,'show'])->name('orders.show');
         Route::patch('orders/{orderId}/payment', [SupermarketOrderWebController::class,'updatePaymentStatus'])->name('orders.payment');
         Route::patch('orders/{orderId}',         [SupermarketOrderWebController::class,'updateOrderStatus'])->name('orders.update');
     });


 Route::get('/features', 'FeatureController@index')->name('features');













   Route::get('/admin/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])
    ->name('general-management.dashboard')
   
;// Dashboard
Route::get('/general-management/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('general_management.dashboard');

// Categories Management


Route::prefix('general-management/reports')->name('general_management.reports.')->group(function () {
    Route::get('/users', [ReportsController::class, 'users'])->name('users');
    Route::get('/orders', [ReportsController::class, 'orders'])->name('orders');
    Route::get('/top-products', [ReportsController::class, 'topProducts'])->name('top_products');
    Route::get('/top-rated-products', [ReportsController::class, 'topRatedProducts'])->name('top_rated_products');
});
// Logout (بناءً على نظامك، قد تحتاج جعله POST وليس GET)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// web.php
Route::resource('general-management/categories', CategoriesController::class)
    ->names([
        'index'   => 'general_management.categories.index',
        'create'  => 'general_management.categories.create',
        'store'   => 'general_management.categories.store',
        'show'    => 'general_management.categories.show',
        'edit'    => 'general_management.categories.edit',
        'update'  => 'general_management.categories.update',
        'destroy' => 'general_management.categories.destroy',
    ]);
