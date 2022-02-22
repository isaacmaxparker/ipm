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

Route::get('/', ['as' => 'index', 'namespace' => 'Site', 'uses' => 'IndexController@viewHome']);

Route::group([
 
    'prefix' => 'music',
    'as' => 'music::',
    'namespace'=>'Site',

], function () {

    Route::get('catalog', ['as' => 'catalog', 'uses' => 'MusicController@viewAll']);
    Route::get('release/{id}', ['as' => 'release', 'uses' => 'MusicController@viewRelease']);
});

Route::group([
 
    'prefix' => 'store',
    'as' => 'store::',
    'namespace'=>'Site',

], function () {

    Route::get('/', ['as' => 'catalog', 'uses' => 'StoreController@viewCatalog']);
    Route::get('product/{id}', ['as' => 'product', 'uses' => 'StoreController@viewProduct']);
    Route::get('cart', ['as' => 'cart', 'uses' => 'StoreController@ViewCart']);
    Route::get('addtocart/{id}', ['as' => 'addtocart', 'uses' => 'StoreController@addToCart']);
    Route::get('deletecart', ['as' => 'deletecart', 'uses' => 'StoreController@deleteCart']);
});
