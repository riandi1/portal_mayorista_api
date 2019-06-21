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


// Users

// Rest
Route::group(['prefix' => 'rest'], function () {
    Route::get('countries', 'RestController@getAllCountry');
    Route::get('states', 'RestController@getAllState');
    Route::get('cities', 'RestController@getAllCity');
    Route::get('documentTypes', 'RestController@getAllDocumentType');
    Route::post('users', 'RestController@storeUser');
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


    // Param
    Route::group(['prefix' => 'param'], function () {
        Route::apiResource('countries', 'CountryController');
        Route::apiResource('states', 'StateController');
        Route::apiResource('cities', 'CityController');
        Route::apiResource('documentTypes', 'DocumentTypeController');
    });

    // Store
    Route::group(['prefix' => 'store'], function () {
        Route::apiResource('categories', 'CategoryController');
        Route::apiResource('categoryFeactures', 'CategoryFeactureController');
        Route::apiResource('products', 'ProductController');
        Route::post('product/favorites/{product}', 'ProductController@favorite');
        Route::delete('product/favorites/{product}', 'ProductController@deleteFavorite');
        Route::get('product/favorites', 'ProductController@listFavorites');
        Route::apiResource('movements', 'ProductMovementController');

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
    Route::apiResource('comments', 'CommentController');

    // Mails
    Route::apiResource('emails', 'EmailController');

    // Dashboard
    Route::group([
        'prefix' => 'dashboard'
    ], function () {
    });

    // Pages
    Route::apiResource('pages', 'PageController');

    // Page Variables
    Route::apiResource('vars', 'PageVarController');

    // CustomFields
    Route::apiResource('custom_fields', 'CustomFieldController');
    Route::get('custom_fields_for/{resource}', 'CustomFieldController@getFields');


    Route::apiResource('conversations', 'ConversationController');
    Route::apiResource('messages', 'MessageController');




});

Route::post('paypal-transaction-complete' , function () {
    return 'hello';
});
/*
Route::get('testnoti', function () {
    $user = \App\Models\System\User::find(1);
    $user->notify(new \App\Notifications\MessageNotification());
    return jsend_success($user, 200, "Notification sending to user: {$user->name}");
});
*/
