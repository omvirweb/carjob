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

//Route::get('/home', 'HomeController@index')->name('index');
//Route::get('{id}/product', 'HomeController@product')->name('product');

// Route::get('/', ['as' => 'home', function () {
//     return view('index');
// }]);

Route::group(array('prefix' => 'admin', 'namespace'=>'Admin', 'middleware' => ['auth']), function () {
    # Dashboard / Index
    Route::get('/dashboard', 'AdminController@showHome')->name('dashboard');

    Route::get('/profile', 'AdminController@Profile')->name('profile');
    Route::post('/updateProfile', 'AdminController@updateProfile')->name('updateProfile');

    # Cars
    Route::resource('cars', 'CarsController');
    Route::post('/save_car', 'CarsController@store');
    Route::get('/getCarsDatatable', 'CarsController@getCarsDatatable');
    Route::post('/carDelete','CarsController@carDelete');

    # Car Models
    Route::resource('car-models', 'CarModelsController');
    Route::post('/save_car_model', 'CarModelsController@store');
    Route::get('/getCarModelsDatatable', 'CarModelsController@getCarModelsDatatable');
    Route::post('/carModelDelete','CarModelsController@carModelDelete');
    Route::get('/getModelsByCar/', 'CarModelsController@getModelsByCar');
    Route::get('/setCarModel/{model}', 'CarModelsController@setCarModel');

    # Tasks
    //Route::resource('tasks', 'TasksController');
    Route::get('tasks','TasksController@index');
    Route::post('tasks','TasksController@create');
    Route::get('tasks','TasksController@store');

    # Order
    Route::resource('order', 'OrderController');
    Route::post('/save_order', 'OrderController@store');
    Route::get('/getOrdersDatatable', 'OrderController@getOrdersDatatable');
    Route::post('/orderDelete','OrderController@orderDelete');
    Route::get('/orderPrint/{order_id}','OrderController@orderPrint');
    
});
