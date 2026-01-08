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


Route::group(['middleware' => ['web']], function(){

	Route::get('/', [
	  	'as' => 'admin.home', 'uses' => 'HomeController@index'
	]);

	Route::get('/dashboard', [
	  	'as' => 'admin.dashboard.index', 'uses' => 'Dashboard\DashboardController@default'
	]);

	Route::get('/dashboard/get-asset-data', [
		'as' => 'admin.dashboard.index', 'uses' => 'Dashboard\DashboardController@getAssetData'
	]);

});

/*
|--------------------------------------------------------------------------
| ADMIN GET ROUTES
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| ADMIN POST ROUTES
|--------------------------------------------------------------------------
*/
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');


Route::get('store', 'StoreController@download')->name('download');

Route::get('stock', 'StoreController@test')->name('download');




