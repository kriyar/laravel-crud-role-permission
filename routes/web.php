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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function() {
  // Manage roles and permissions
  Route::prefix('admin')->group(function () {
    Route::resource('/roles', 'RolePermission\RoleController');
    Route::resource('/permissions', 'RolePermission\PermissionController');
    Route::get('/role-permission', 'RolePermission\RolePermissionController@index')->name('role.permission');
    Route::post('/role-permission', 'RolePermission\RolePermissionController@store')->name('role.permission');
    Route::post('/filter/role-permission', 'RolePermission\RolePermissionController@assignFilter')->name('filter.role.permission');
  });

  // Manage user roles
  Route::get('/user/list', 'RolePermission\UserRoleController@index')->name('user.list');
  Route::get('/user/{user}/role', 'RolePermission\UserRoleController@edit')->name('user.role');
  Route::post('/user/{user}/role', 'RolePermission\UserRoleController@update')->name('user.role');
});
