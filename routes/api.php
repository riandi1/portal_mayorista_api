<?php

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
        Route::get('notifications', 'AuthController@notifications')->name('auth.notifications');
        Route::put('notifications/read', 'AuthController@readNotifications')->name('auth.read_notifications');
        Route::put('fcm/{token}', 'AuthController@setFCM')->name('auth.set_fcm');
        Route::post('/pusher', function (\Illuminate\Http\Request $request) {
            $pusher = new Pusher(
                config('broadcasting.connections.pusher.key'),
                config('broadcasting.connections.pusher.secret'),
                config('broadcasting.connections.pusher.app_id'),
                config('broadcasting.connections.pusher.options')
            );
            return $pusher->socket_auth($request->get('channel_name'), $request->get('socket_id'));
        });
    });
});

// Password
Route::group(['prefix' => 'password'], function () {
    Route::post('create', 'AuthController@create');
    Route::get('find/{token}', 'AuthController@find');
    Route::post('reset', 'AuthController@reset');
});




Route::group(['middleware' => ['web']], function () {
    //Socialite
    Route::get('/redirect/{provider}', 'AuthController@redirect');
    Route::get('/callback/{provider}', 'AuthController@callback');

});


// Users

// Rest
Route::group(['prefix' => 'rest'], function () {
    Route::post('users', 'RestController@storeUser');
    Route::get('signup/activate/{token}', 'RestController@signupActivate');
    Route::get('categories', 'RestController@listCategory');
    Route::get('products', 'RestController@listProduct');
    Route::get('products/{id}', 'RestController@product');
});


// PANEL ROUTES
Route::group([
    'middleware' => 'auth:api'
], function () {

    // Users
    Route::apiResource('users', 'UserController');
    Route::post('users/{user_id}/message', 'UserController@message');
    Route::put('user/{id}/image', 'UserController@updateImage')->name('user.image');
    Route::put('user/{id}/roles', 'UserController@updateRoles')->name('user.roles');
    Route::post('user/{id}/valuation', 'UserController@valuation');
    Route::get('user/{id}/valuation', 'UserController@valuationUser');

    // Store
    Route::group(['prefix' => 'store'], function () {
        Route::apiResource('categories', 'CategoryController');
        Route::apiResource('categoryFeactures', 'CategoryFeactureController');
        Route::apiResource('products', 'ProductController');
        Route::post('product/favorites/{product}', 'ProductController@favorite');
        Route::delete('product/favorites/{product}', 'ProductController@deleteFavorite');
        Route::get('product/favorites', 'ProductController@listFavorites');
        Route::delete('product/{id}/reported', 'ProductController@reported');
        Route::get('product/active', 'ProductController@listProductActive');
        Route::post('product/{id}/active', 'ProductController@productActive');

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

    // Comments
    Route::get('comments/{id}', 'CommentController@index');
    Route::post('comments/{id}', 'CommentController@created');
    Route::delete('comments/{id}', 'CommentController@delete');

    // Mails
    Route::apiResource('emails', 'EmailController');


    // Pages
    Route::apiResource('pages', 'PageController');

    // Page Variables
    Route::apiResource('vars', 'PageVarController');

    // CustomFields
    Route::apiResource('custom_fields', 'CustomFieldController');
    Route::get('custom_fields_for/{resource}', 'CustomFieldController@getFields');

    Route::group(['prefix' => 'chat'], function () {
        Route::get('conversations', 'ChatController@indexConversation');
        Route::get('conversations/{id}', 'ChatController@showConversation');
        Route::delete('conversations/{id}', 'ChatController@deleteConversation');
        Route::post('messages/{id}', 'ChatController@storeMessage');
        Route::delete('messages/{id}', 'ChatController@deleteMessage');
    });

});

Route::post('paypal-transaction-complete' , function () {
    return 'hello';
});
