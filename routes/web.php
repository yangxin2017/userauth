<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//严格模式：Accept: application/vnd.userauth.v1+json
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', ['namespace' => 'App\Http\Controllers\V1'], function($api){

    $api->post('/auth/login', [
        'as' => 'user.auth.login',
        'uses' => 'UserInfoController@GetUser'
    ]);

    $api->group(['middleware' => ['api.auth', 'useradmin']], function($api){

        $api->get('/auth/isauth', [
            'as' => 'user.auth.isauth',
            'uses' => 'UserInfoController@IsHaveAuth'
        ]);
        
        $api->post('/manager/menu/add/', [
            'as' => 'admin.menu.add',
            'uses' => 'AuthMenuController@AddMenu'
        ]);

        $api->put('/manager/menu/update/{id}', [
            'as' => 'admin.menu.update',
            'uses' => 'AuthMenuController@UpdateMenu'
        ]);

        $api->get('/manager/menu/getlist', [
            'as' => 'admin.menu.get',
            'uses' => 'AuthMenuController@GetMenus'
        ]);

        $api->delete('/manager/menu/delete/{id}', [
            'as' => 'admin.menu.delete',
            'uses' => 'AuthMenuController@DeleteMenu'
        ]);

        //Role
        $api->get('/manager/role/checkname', [
            'as' => 'admin.role.check',
            'uses' => 'UserRoleController@CheckLoginNameExist'
        ]);

        $api->post('/manager/role/add', [
            'as' => 'admin.role.add',
            'uses' => 'UserRoleController@AddRole'
        ]);

        $api->put('/manager/role/update/{id}', [
            'as' => 'admin.role.update',
            'uses' => 'UserRoleController@UpdateRole'
        ]);

        $api->get('/manager/role/getlist', [
            'as' => 'admin.role.get',
            'uses' => 'UserRoleController@GetRoles'
        ]);

        $api->delete('/manager/role/delete/{id}', [
            'as' => 'admin.role.delete',
            'uses' => 'UserRoleController@DeleteRole'
        ]);

        //User & UserInfo

        $api->get('/manager/user/checkemail', [
            'as' => 'admin.user.check',
            'uses' => 'UserInfoController@CheckEmail'
        ]);

        $api->post('/manager/user/add', [
            'as' => 'admin.user.add',
            'uses' => 'UserInfoController@AddUser'
        ]);

        $api->put('/manager/user/update/{id}', [
            'as' => 'admin.user.update',
            'uses' => 'UserInfoController@UpdateUser'
        ]);

        $api->get('/manager/user/getlist', [
            'as' => 'admin.user.get',
            'uses' => 'UserInfoController@GetUsers'
        ]);

        $api->delete('/manager/user/delete/{id}', [
            'as' => 'admin.user.delete',
            'uses' => 'UserInfoController@DeleteUser'
        ]);

        $api->post('/manager/user/freeze/{id}', [
            'as' => 'admin.user.freeze',
            'uses' => 'UserInfoController@FreezeUser'
        ]);

    });

});