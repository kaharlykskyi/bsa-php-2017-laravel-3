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
    return view('welcome');
});

Route::prefix('cars')->group(function () {
    Route::get('/', 'CarsController@index')->name('cars-list');
    Route::get('/create', 'CarsController@create')->name('cars-create');
    Route::post('/', 'CarsController@store')->name('cars-store');

    Route::prefix('{id}')->group(function () {
        Route::get('/', 'CarsController@show')->name('cars-show');
        Route::put('/', 'CarsController@update')->name('cars-update');
        Route::get('/edit', 'CarsController@edit')->name('cars-edit');
        Route::get('/delete', 'CarsController@delete')->name('cars-delete');
    });
});
