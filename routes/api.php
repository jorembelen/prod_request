<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');

Route::middleware('auth:api')->group(function () {
    Route::get('user', 'Api\AuthController@details');
    Route::post('logout', 'Api\AuthController@logout');

    Route::get('all-users', 'Api\DashboardController@getUsers');
    Route::post('create-user', 'Api\DashboardController@addUser');
    Route::post('update-user', 'Api\DashboardController@updateUser');
    Route::post('remove-user', 'Api\DashboardController@removeUser');

    Route::get('all-categories', 'Api\DashboardController@getCategories');
    Route::post('create-category', 'Api\DashboardController@addCategory');
    Route::post('update-category', 'Api\DashboardController@updateCategory');
    Route::post('remove-category', 'Api\DashboardController@removeCategory');

    Route::get('all-catalogs', 'Api\DashboardController@getCatalogs');
    Route::post('create-catalog', 'Api\DashboardController@addCatalog');
    Route::post('update-catalog', 'Api\DashboardController@updateCatalog');
    Route::post('remove-catalog', 'Api\DashboardController@removeCatalog');

    Route::get('all-products', 'Api\DashboardController@getProducts');
    Route::post('create-product', 'Api\DashboardController@addProduct');
    Route::post('update-product', 'Api\DashboardController@updateProduct');
    Route::post('remove-product', 'Api\DashboardController@removeProduct');
});