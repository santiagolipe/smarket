<?php

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

Route::get('/', function () {
    if(Auth::check()) {
        return Redirect::to('home');
    }

    return view('index');
})->name('index');

Route::get('/terms', function() {
    return view('terms');
})->name('terms');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/my-account',  ['as' => 'my-account', 'uses' => 'UserController@index']);
Route::patch('/users/{user_id}/update',  ['as' => 'users.update', 'uses' => 'UserController@update']);
Route::get('/users/{user_id}/delete',  ['as' => 'users.delete', 'uses' => 'UserController@delete']);

Route::group(['middleware' => 'auth'], function() {
    Route::get('/support', function() {
        return view('support');
    })->name('support');
});

Route::group(['middleware' => 'cliente'], function() {
    Route::get('/markets',  ['as' => 'users.lojista.list', 'uses' => 'LojistaController@list']);
    Route::get('/markets/{id}',  ['as' => 'users.lojista.items', 'uses' => 'LojistaController@items']);
    Route::get('/markets/{id}/{product}',  ['as' => 'users.lojista.item', 'uses' => 'LojistaController@item']);
    Route::post('/add-to-cart',  ['as' => 'cart.add', 'uses' => 'CartController@addItem']);
    Route::post('/buy-now',  ['as' => 'cart.buy', 'uses' => 'CartController@buyNow']);
    Route::get('/clear-cart',  ['as' => 'cart.clear', 'uses' => 'CartController@clear']);
    Route::get('/cart/{item}/remove',  ['as' => 'cart.remove', 'uses' => 'CartController@removeItem']);
    Route::get('/checkout',  ['as' => 'checkout', 'uses' => 'CheckoutController@index']);
    Route::post('/checkout',  ['as' => 'checkout', 'uses' => 'CheckoutController@checkout']);
    Route::post('/deliveryfee/find',  ['as' => 'deliveryfee.find', 'uses' => 'DeliveryFeeController@findAndUpdateCart']);
    Route::post('/deliveryfee/clear',  ['as' => 'deliveryfee.clear', 'uses' => 'DeliveryFeeController@clearFee']);
    Route::get('/my-orders',  ['as' => 'orders.list', 'uses' => 'OrderController@list']);
});

Route::group(['middleware' => 'lojista'], function() {
    Route::get('/product',  ['as' => 'product', 'uses' => 'ProductController@index']);
    Route::get('/products',  ['as' => 'products.list', 'uses' => 'ProductController@list']);
    Route::post('/product',  ['as' => 'products.create', 'uses' => 'ProductController@create']);
    Route::get('/product/{id}/edit',  ['as' => 'products.edit', 'uses' => 'ProductController@edit']);
    Route::patch('/product/{id}/update',  ['as' => 'products.update', 'uses' => 'ProductController@update']);
    Route::get('/product/{id}/delete',  ['as' => 'products.delete', 'uses' => 'ProductController@delete']);
    Route::get('/product/{id}/restore',  ['as' => 'products.restore', 'uses' => 'ProductController@restore']);
    Route::get('/sales',  ['as' => 'sales', 'uses' => 'OrderController@listMarket']);
    Route::get('/sales-report',  ['as' => 'sales.list', 'uses' => 'OrderController@report']);
    Route::get('/sales-report/print',  ['as' => 'sales.list.print', 'uses' => 'OrderController@printReport']);
    Route::get('/delivery',  ['as' => 'deliveryfee.list', 'uses' => 'DeliveryFeeController@list']);
    Route::post('/delivery',  ['as' => 'deliveryfee.create', 'uses' => 'DeliveryFeeController@create']);
    Route::patch('/delivery/{id}/update',  ['as' => 'deliveryfee.update', 'uses' => 'DeliveryFeeController@update']);
    Route::get('/delivery/{id}/delete',  ['as' => 'deliveryfee.delete', 'uses' => 'DeliveryFeeController@delete']);
    Route::get('/order/{id}/print',  ['as' => 'order.print', 'uses' => 'OrderController@print']);
});
