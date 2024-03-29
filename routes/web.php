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
    Route::get('latest', ['as' => 'latest', 'uses' => 'MusicController@viewLatest']);
    Route::get('release/{id}', ['as' => 'release', 'uses' => 'MusicController@viewRelease']);
});

Route::group([
 
    'prefix' => 'store',
    'as' => 'store::',
    'namespace'=>'Site',

], function () {

    Route::get('/', ['as' => 'catalog', 'uses' => 'StoreController@viewCatalog']);
    Route::get('product/{id}', ['as' => 'product', 'uses' => 'StoreController@viewProduct']);
    Route::get('addtocart/{id}', ['as' => 'addtocart', 'uses' => 'StoreController@addToCart']);
    Route::get('cart', ['as' => 'cart', 'uses' => 'StoreController@ViewCart']);
    Route::get('checkout', ['as' => 'checkout', 'uses' => 'StoreController@ViewCheckout']);
    Route::get('addpromo', ['as' => 'addpromo', 'uses' => 'StoreController@ValidatePromo']);
    Route::get('removepromo', ['as' => 'removedpromo', 'uses' => 'StoreController@RemovePromo']);
    Route::get('removefromcart', ['as' => 'removefromcart', 'uses' => 'StoreController@deleteFromCart']);
    Route::get('deletecart', ['as' => 'deletecart', 'uses' => 'StoreController@deleteCart']);
    Route::get('ordertotal', ['as' => 'ordertotal', 'uses' => 'StoreController@getOrderTotal']);
    Route::post('saveorder', ['as' => 'saveorder', 'uses' => 'StoreController@saveOrder']);
    Route::get('order/{order_id}', ['as' => 'order', 'uses' => 'StoreController@viewOrder']);
});

Route::group([
 
    'prefix' => 'admin',
    'as' => 'admin::',
    'namespace'=>'Admin',

], function () {

    Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'AdminController@viewAdminDashboard']);
    Route::get('/login', ['as' => 'login', 'uses' => 'AdminController@viewLogin']);
    Route::post('/login', ['as' => 'loginsubmit', 'uses' => 'AdminController@login']);
    Route::get('/logout', ['as' => 'logout', 'uses' => 'AdminController@logout']);
    Route::get('/releases', ['as' => 'releases', 'uses' => 'AdminController@viewReleases']);
    Route::get('/newrelease', ['as' => 'newrelease', 'uses' => 'AdminController@newRelease']);
    Route::get('/deleterelease', ['as' => 'deleterelease', 'uses' => 'AdminController@deleteRelease']);
    Route::post('/saverelease', ['as' => 'savenewrelease', 'uses' => 'AdminController@saveNewRelease']);
    Route::post('/saverelease/{id}', ['as' => 'saverelease', 'uses' => 'AdminController@saveRelease']);
    Route::get('/release/{id}', ['as' => 'editrelease', 'uses' => 'AdminController@editRelease']);
    Route::get('/songs', ['as' => 'songs', 'uses' => 'AdminController@viewSongs']);
    Route::get('/products', ['as' => 'products', 'uses' => 'AdminController@viewProducts']);
    Route::get('/orders', ['as' => 'orders', 'uses' => 'AdminController@viewOrders']);
    Route::get('/promos', ['as' => 'promos', 'uses' => 'AdminController@viewPromos']);
    Route::get('/customers', ['as' => 'customers', 'uses' => 'AdminController@viewCustomers']);
    Route::get('/tiles', ['as' => 'tiles', 'uses' => 'AdminController@viewTiles']);

});

Route::group([
 
    'prefix' => 'portfolio',
    'as' => 'portfolio::',
    'namespace'=>'Site',

], function () {

    Route::get('/', ['as' => 'index', 'uses' => 'PortfolioController@view']);
});
