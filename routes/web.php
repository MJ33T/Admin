<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\MerchantController;
use App\Models\MerchantUser;

// use Session;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::post('/login', [AdminController::class, 'login']);

Route::get('/merchant_login', [MerchantController::class, 'merchant_login_view']);

Route::post('/merchant_login', [MerchantController::class, 'merchant_login']);

Route::get('/merchant_dashboard', [MerchantController::class, 'merchant_dashboard']);

Route::get('/merchant_register', [MerchantController::class, 'merchant_register_view']);

Route::post('/merchant_register', [MerchantController::class, 'merchant_register']);

Route::get('/merchant_product', [MerchantController::class, 'merchant_product']);

Route::get('/merchant_add_product', [MerchantController::class, 'merchant_add_product']);

Route::get('/merchant_brand', [MerchantController::class, 'merchant_brand']);

Route::get('/merchant_sub_brand', [MerchantController::class, 'merchant_sub_brand']);

Route::get('/merchant_voucher', [MerchantController::class, 'merchant_voucher']);

Route::get('/merchant_promotion', [MerchantController::class, 'merchant_promotion']);

Route::get('/merchant_sales', [MerchantController::class, 'merchant_sales']);

Route::get('/merchant_logout', [MerchantController::class, 'merchant_logout']);

Route::get('/admin', [ViewController::class, 'admin']);

Route::get('/logout', function () {
    Session::forget('user');
    return redirect('/admin');
});

Route::get('merchat_session', function () {
    return [
        'merchant' => session()->get('merchant'),
    ];
});

Route::get('/dashboard', [ViewController::class, 'dashboard']);

Route::get('/floor', [ViewController::class, 'floor']);

Route::get('/category', [ViewController::class, 'category']);

Route::get('/product', [ViewController::class, 'product']);

Route::get('/brand', [ViewController::class, 'brand']);

Route::get('/sub_brand', [ViewController::class, 'sub_brand']);

Route::get('/sub_brand_detail', [ViewController::class, 'sub_brand_detail']);

Route::get('/merchant', [ViewController::class, 'merchant']);

Route::get('/mall', [ViewController::class, 'mall']);

Route::get('/selling_identity', [ViewController::class, 'selling_indentity']);

Route::get('/new_shop', [ViewController::class, 'new_shop']);

Route::get('/used_shop', [ViewController::class, 'used_shop']);

Route::get('/other_mall', [ViewController::class, 'other_mall']);

Route::get('/voucher', [ViewController::class, 'voucher']);

Route::get('/promotion', [ViewController::class, 'promotion']);

Route::get('/ads_client', [ViewController::class, 'ads_client']);

Route::get('/create_ads', [ViewController::class, 'create_ads']);

Route::get('/ads_schedule', [ViewController::class, 'ads_schedule']);

Route::get('/manage_admin', [ViewController::class, 'manage_admin']);

Route::get('/sales', [ViewController::class, 'sales']);

Route::get('/reports', [ViewController::class, 'reports']);

Route::get('/transaction', [ViewController::class, 'transaction']);
