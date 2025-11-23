<?php
use Illuminate\Support\Facades\Route;
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
Route::middleware('auth')->group(function() {
    Route::get('admin/', function () {
        return view('admin/index');
    }); 
    //アカウント管理
    Route::post('admin/user/create-confirm', 'App\Http\Controllers\Admin\UserController@create_confirm')->name('user.create-confirm');
    Route::post('admin/user/{user}/edit-confirm', 'App\Http\Controllers\Admin\UserController@edit_confirm')->name('user.edit-confirm');
    Route::get('admin/user/complete', 'App\Http\Controllers\Admin\UserController@complete')->name('user.complete');
    Route::resource('admin/user', 'App\Http\Controllers\Admin\UserController', ['except' => ['destroy']]);
    // //商品管理
    // Route::post('admin/product/create-confirm', 'App\Http\Controllers\Admin\ProductController@create_confirm')->name('product.create-confirm');
    // Route::post('admin/product/{product}/edit-confirm', 'App\Http\Controllers\Admin\ProductController@edit_confirm')->name('product.edit-confirm');
    // Route::get('admin/product/{product}/destroy-confirm', 'App\Http\Controllers\Admin\ProductController@destroy_confirm')->name('product.destroy-confirm');
    // Route::get('admin/product/complete', 'App\Http\Controllers\Admin\ProductController@complete')->name('product.complete');
    // Route::get('admin/product/{product}/copying', 'App\Http\Controllers\Admin\ProductController@copying')->name('product.copying');
    // Route::resource('admin/product', 'App\Http\Controllers\Admin\ProductController');
    // //キービジュアル管理
    Route::post('admin/key_visual/create-confirm', 'App\Http\Controllers\Admin\KeyVisualController@create_confirm')->name('key_visual.create-confirm');
    Route::post('admin/key_visual/{key_visual}/edit-confirm', 'App\Http\Controllers\Admin\KeyVisualController@edit_confirm')->name('key_visual.edit-confirm');
    Route::get('admin/key_visual/{key_visual}/destroy-confirm', 'App\Http\Controllers\Admin\KeyVisualController@destroy_confirm')->name('key_visual.destroy-confirm');
    Route::get('admin/key_visual/complete', 'App\Http\Controllers\Admin\KeyVisualController@complete')->name('key_visual.complete');
    Route::resource('admin/key_visual', 'App\Http\Controllers\Admin\KeyVisualController');
    // //振込管理
    // Route::post('admin/transfer/create-confirm', 'App\Http\Controllers\Admin\TransferController@create_confirm')->name('transfer.create-confirm');
    // Route::post('admin/transfer/{transfer}/edit-confirm', 'App\Http\Controllers\Admin\TransferController@edit_confirm')->name('transfer.edit-confirm');
    // Route::get('admin/transfer/{transfer}/destroy-confirm', 'App\Http\Controllers\Admin\TransferController@destroy_confirm')->name('transfer.destroy-confirm');
    // Route::get('admin/transfer/complete', 'App\Http\Controllers\Admin\TransferController@complete')->name('transfer.complete');
    // Route::resource('admin/transfer', 'App\Http\Controllers\Admin\TransferController');
});
//フロントサイト
Route::get('/', 'App\Http\Controllers\Front\TopController@index')->name('top.index');
// Route::get('category/{category}', 'App\Http\Controllers\Front\ProductController@index')->name('front-product.index');
// Route::get('product/{product}', 'App\Http\Controllers\Front\ProductController@show')->name('front-product.show');
// Route::get('inquiry/', 'App\Http\Controllers\Front\InquiryController@index')->name('front-inquiry.index');
// Route::post('inquiry/confirm', 'App\Http\Controllers\Front\InquiryController@confirm')->name('front-inquiry.confirm');
// Route::post('inquiry/', 'App\Http\Controllers\Front\InquiryController@send')->name('front-inquiry.send');
// Route::get('inquiry/complete', 'App\Http\Controllers\Front\InquiryController@complete')->name('front-inquiry.complete');
// Route::get('privacypolicy/', 'App\Http\Controllers\Front\PrivacyPolicyController@index')->name('front-privacypolicy.index');
// Route::get('transfer/input-transfer', 'App\Http\Controllers\Front\TransferController@input_transfer')->name('front-payment.input-transfer');
// Route::post('transfer/confirm-transfer', 'App\Http\Controllers\Front\TransferController@confirm_transfer')->name('front-payment.confirm-transfer');
// Route::post('transfer/input-payment', 'App\Http\Controllers\Front\TransferController@input_payment')->name('front-payment.input-payment');
// Route::post('transfer/get-token', 'App\Http\Controllers\Front\TransferController@get_token')->name('front-payment.get-token');
// Route::post('transfer/payment-completion', 'App\Http\Controllers\Front\TransferController@payment_completion')->name('front-payment.payment-completion');
require __DIR__.'/auth.php';