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

    //商品カテゴリ管理
    Route::post('admin/category/create-confirm', 'App\Http\Controllers\Admin\CategoryController@create_confirm')->name('category.create-confirm');
    Route::post('admin/category/{category}/edit-confirm', 'App\Http\Controllers\Admin\CategoryController@edit_confirm')->name('category.edit-confirm');
    Route::get('admin/category/{category}/destroy-confirm', 'App\Http\Controllers\Admin\CategoryController@destroy_confirm')->name('category.destroy-confirm');
    Route::get('admin/category/complete', 'App\Http\Controllers\Admin\CategoryController@complete')->name('category.complete');
    Route::resource('admin/category', 'App\Http\Controllers\Admin\CategoryController');

    //商品サブカテゴリ管理
    Route::get('admin/category/{category}/sub_category', 'App\Http\Controllers\Admin\SubCategoryController@index')->name('sub_category.index');
    Route::post('admin/category/{category}/sub_category', 'App\Http\Controllers\Admin\SubCategoryController@batch_update_confirm')->name('sub_category.batch_update_confirm');
    Route::patch('admin/category/{category}/sub_category', 'App\Http\Controllers\Admin\SubCategoryController@batch_update')->name('sub_category.batch_update');
    Route::get('admin/category/{category}/sub_category/complete', 'App\Http\Controllers\Admin\SubCategoryController@complete')->name('sub_category.complete');

    //商品管理
    Route::post('admin/goods/create-confirm', 'App\Http\Controllers\Admin\GoodsController@create_confirm')->name('goods.create-confirm');
    Route::post('admin/goods/{goods}/edit-confirm', 'App\Http\Controllers\Admin\GoodsController@edit_confirm')->name('goods.edit-confirm');
    Route::get('admin/goods/{goods}/destroy-confirm', 'App\Http\Controllers\Admin\GoodsController@destroy_confirm')->name('goods.destroy-confirm');
    Route::get('admin/goods/complete', 'App\Http\Controllers\Admin\GoodsController@complete')->name('goods.complete');
    Route::get('admin/goods/{goods}/copying', 'App\Http\Controllers\Admin\GoodsController@copying')->name('goods.copying');
    Route::resource('admin/goods', 'App\Http\Controllers\Admin\GoodsController');

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
// Route::get('category/{category}', 'App\Http\Controllers\Front\GoodsController@index')->name('front-goods.index');
// Route::get('goods/{goods}', 'App\Http\Controllers\Front\GoodsController@show')->name('front-goods.show');
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