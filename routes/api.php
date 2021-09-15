<?php

use App\Http\Controllers\API\main_bannerController;
use App\Models\System\User;
use Pusher\Pusher;

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


Route::get('/', function () {
    return view('welcome');
});

// AUTH
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login')->name('auth.login');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::delete('logout', 'AuthController@logout')->name('auth.logout');
        Route::put('change', 'AuthController@change');
        Route::get('validate', 'AuthController@validate')->name('auth.validate');
    });
});

// Password
Route::group(['prefix' => 'password'], function () {
    Route::post('restore', 'AuthController@restore');
    Route::get('find/{token}', 'AuthController@find');
    Route::post('reset', 'AuthController@reset');
});


// Rest
Route::group(['prefix' => 'rest'], function () {
    Route::post('users', 'RestController@storeUser');
    Route::get('categories', 'RestController@listCategory');
    Route::get('main', 'RestController@mainBanner');
    Route::get('footer', 'RestController@footerBanner');
    Route::get('products', 'RestController@listProduct');
    Route::get('products/{id}', 'RestController@product');
});

//endpoints
Route::post('main_banner', 'API\main_bannerController@store');



// PANEL ROUTES
Route::group([
    'middleware' => 'auth:api'
], function () {

    // Users
    Route::apiResource('users', 'UserController');


    Route::apiResource('recharges', 'UserRechargeController');

    // Store
    Route::group(['prefix' => 'store'], function () {
        Route::apiResource('categories', 'CategoryController');
        Route::apiResource('categoryFeactures', 'CategoryFeactureController');
        Route::apiResource('products', 'ProductController');
    });

    // Roles
    Route::apiResource('roles', 'RoleController');
    Route::put('role/{id}/permissions', 'RoleController@updatePermissions')->name('role.permissions');

    // Permissions
    Route::apiResource('permissions', 'PermissionController')->only('index', 'show');
    Route::get('permision/has/{permission_name}', 'PermissionController@hasPermissionTo')->name('permission.has');

    // Binnacle
    Route::apiResource('binnacle', 'BinnacleController');


    // Parameters
    Route::apiResource('parameters', 'ParameterController');

    // Tags
    Route::apiResource('tags', 'TagController');
    Route::apiResource('assignments', 'TagAssignmentController');


    // Pages
    Route::apiResource('pages', 'PageController');

    // Page Variables
    Route::apiResource('vars', 'PageVarController');

    // CustomFields
    Route::apiResource('custom_fields', 'CustomFieldController');
    Route::get('custom_fields_for/{resource}', 'CustomFieldController@getFields');


});

