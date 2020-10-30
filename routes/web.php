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

//Auth::routes();

Route::get('/', 'FrontEndController@getLogin')->name('login'); 
Route::get('login', 'FrontEndController@getLogin')->name('login'); 
Route::post('login', 'FrontEndController@postLogin')->name('login');
Route::post('logout', 'FrontEndController@getLogout')->name('logout');

Route::get('/home', 'HomeController@index')->name('index');
Route::get('{id}/product', 'HomeController@product')->name('product');

// Route::get('/', ['as' => 'home', function () {
//     return view('index');
// }]);

Route::group(array('prefix' => 'admin', 'namespace'=>'Admin', 'middleware' => ['auth']), function () {
    # Dashboard / Index
    Route::get('/dashboard', 'AdminController@showHome')->name('dashboard');

    # Category
    Route::get('/categoryList','CategoryController@categoryList')->name('categoryList');
    Route::post('/categoryInsert','CategoryController@categoryInsert')->name('categoryInsert');
    Route::post('/getCategory','CategoryController@getCategory')->name('getCategory');
    Route::post('/categoryUpdate','CategoryController@categoryUpdate')->name('categoryUpdate');
    Route::post('/categoryDelete','CategoryController@categoryDelete')->name('categoryDelete');

    # Item
    Route::get('/itemList','ItemController@itemList')->name('itemList');
    Route::post('/itemInsert','ItemController@itemInsert')->name('itemInsert');
    Route::post('/getItem','ItemController@getItem')->name('getItem');
    Route::post('/itemUpdate','ItemController@itemUpdate')->name('itemUpdate');
    Route::post('/itemDelete','ItemController@itemDelete')->name('itemDelete');

    # Distributor
    Route::get('/distributorList','DistributorController@distributorList')->name('distributorList');
    Route::post('/distributorInsert','DistributorController@distributorInsert')->name('distributorInsert');
    Route::post('/getDistributor','DistributorController@getDistributor')->name('getDistributor');
    Route::post('/distributorUpdate','DistributorController@distributorUpdate')->name('distributorUpdate');
    Route::post('/distributorDelete','DistributorController@distributorDelete')->name('distributorDelete');

    # Item Details
    Route::resource('item-details', 'ItemDetailsController');
    
    # Order
    Route::resource('order', 'OrderController');
    Route::post('/save_order', 'OrderController@store');
    Route::get('/getOrdersDatatable', 'OrderController@getOrdersDatatable');
    
});
