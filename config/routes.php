<?php

declare(strict_types=1);

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use Hyperf\HttpServer\Router\Router;

/**
 * #########startt
 */
Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::get('/favicon.ico', function () {
    return '';
});
Router::addGroup('/user', function () {
    Router::post('/register', 'App\Controller\UserController@userRegister');
    Router::post('/login', 'App\Controller\UserController@userLogin');
    Router::post('/check/token', 'App\Controller\UserController@checkToken');

    Router::addGroup('/friend', function () {
        // 列表
        Router::get('/list', 'App\Controller\UserController@friendList');
        // 查找朋友
        Router::post('/find', 'App\Controller\UserController@friendFind');
        // 添加朋友
        Router::post('/add', 'App\Controller\UserController@friendAdd');
        // 删除朋友
        Router::post('/delete', 'App\Controller\UserController@friendDelete');
    }, ['middleware' => [\App\Middleware\LoginMiddleware::class]]);

    Router::addGroup('/group', function () {
        // 查找组
        Router::post('/add', 'App\Controller\GroupController@add');
        // 编辑组
        Router::post('/edit', 'App\Controller\GroupController@edit');
        // 删除组
        Router::post('/delete', 'App\Controller\GroupController@delete');
        // 添加朋友
        Router::post('/friend/add', 'App\Controller\GroupController@friendAdd');
        // 删除朋友
        Router::post('/friend/delete', 'App\Controller\GroupController@friendDelete');
        // 分组信息
        Router::get('/list', 'App\Controller\GroupController@groupList');

    }, ['middleware' => [\App\Middleware\LoginMiddleware::class]]);
});
/**
 * #########end
 */


/** socket */
Router::addServer('ws', function () {
    Router::get('/', 'App\Controller\WebSocket\WebSocketController');
});
