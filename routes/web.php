<?php

use Illuminate\Support\Facades\Auth;
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

// Example Routes
// Route::view('/', 'landing');
// Route::view('/examples/plugin', 'examples.plugin');
// Route::view('/examples/blank', 'examples.blank');

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout'); //view
// Route::get('/home', 'HomeController@index')->name('home');

Route::group([ 'middleware' => 'role:developer'], function () {

    Route::resource('/permissions', 'PermissionsController');
    Route::resource('/users_permissions', 'UsersPermissionsController');
});

Route::get('/orders/export-csv', 'OrdersController@exportOrdersCSV');
Route::get('/orders/export-xls', 'OrdersController@exportOrdersXLS');

Route::group(['middleware' => ['auth','block','auth.changePassword']], function () {

    Route::get('/dashboard', 'DashboardController@dashboard1')->name('dashboard');
    Route::get('/', 'DashboardController@dashboard1');
    Route::get('/home', 'DashboardController@dashboard1')->name('home');

    //------------- ROLES&PERMISSIONS
    Route::resource('/users', 'UsersController')->names([
        'index' => 'users.index',
        'show' => 'users.show'
    ]);

    Route::resource('/roles', 'RolesController')->names([
        'index' => 'roles.index',
        'show' => 'roles.show'
    ]);

    Route::resource('/examples', 'ExamplesController');
    Route::resource('/roles', 'RolesController');
    Route::resource('/roles_permissions', 'RolesPermissionsController');

    Route::resource('/users_roles', 'UserRolesController');

    Route::get('/profile', 'Auth\ProfilesController@index')->name('profiles.index');
    Route::Post('/profile', 'Auth\ProfilesController@store')->name('profiles.store');
    Route::get('/change-password', 'Auth\ChangePasswordController@index')->name('change_passwords.index');
    
    Route::get('/roles-permissions/{id}', 'RolesPermissionsController@listByRoles')->name('roles.update_permissions_roles');
    Route::Post('/store-roles', 'RolesPermissionsController@storeRoles')->name('rolesPermission.storeRoles');
    Route::get('/roles-users/{id}', 'UserRolesController@listByRoles')->name('roles.update_user_roles');
    Route::Post('/update-roles-users', 'UserRolesController@storeRoles')->name('userRoles.storeRoles');

    Route::get('/users-permissions/{id}', 'UsersPermissionsController@listByUser')->name('users.list_permissions');

    Route::get('/view-logs', 'ViewLogsController@sysLogsUser2')->name('view_logs.show');
    Route::post('/view-logs', 'ViewLogsController@sysLogsUser2');

    Route::resource('/billings', 'BillingsController');
    Route::resource('/inventory', 'InventoryController');
    Route::resource('/orders', 'OrdersController')->middleware('RolePermission');
    Route::resource('/order_items', 'OrderItemsController');
    Route::resource('/configs', 'ConfigsController');

    Route::post('/resend-license', 'OrdersController@reSendLicense')->name('orders.resend');

    Route::fallback(function () {
        return view('errors.404');
    });
});

Route::get('/change-password/{token}', 'Auth\ChangePasswordController@forceChangPassword')->name('changePasswords.forceChangPassword')->middleware('auth');
Route::Post('/change-password', 'Auth\ChangePasswordController@store')->name('changePasswords.store')->middleware('auth');



Route::get('/test', 'testController@test');

// Route::get('/', function () {
//     return view('errors.404');
// });
// Route::get('/login', function () {
//     return view('errors.404');
// });

/** 
 * SiS Microsoft ESD
 *
 * Modify/Update BY PRASONG PUTICHANCHAI
 * 
 * Latest Update : 13/12/2021 11:00
 * Version : ver.0.00.01
 *
 */
