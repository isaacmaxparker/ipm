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

], function () {

    Route::get('/', ['as' => 'index', 'uses' => 'StoreController@view']);

});
