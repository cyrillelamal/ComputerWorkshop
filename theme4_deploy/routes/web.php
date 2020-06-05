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

$router->get('/', [
    'as' => 'index', 'uses'=> 'ThemeController@index'
]);

$router->group(['prefix' => 'theme'], function () use ($router) {
    $router->post('/create', [
        'middleware' => 'auth',
        'as' => 'theme_create', 'uses' => 'ThemeController@create'
    ]);
    $router->get('/{themeSlug}', [
        'as' => 'theme_detail', 'uses' => 'ThemeController@read'
    ]);
    $router->put('/{themeSlug}', [
        'middleware' => 'auth',
        'as' => 'theme_update', 'uses' => 'ThemeController@update'
    ]);
    $router->delete('/{themeSlug}', [
        'middleware' => 'auth',
        'as' => 'theme_delete', 'uses' => 'ThemeController@delete'
    ]);
});

$router->group(['prefix' => 'article'], function () use ($router) {
    $router->post('/{themeSlug}/{articleSlug}', [
        'middleware' => 'auth',
        'as' => 'article_create', 'uses' => 'ThemeController@create'
    ]);
    $router->put('/{themeSlug}/{articleSlug}', [
        'middleware' => 'auth',
        'as' => 'article_detail', 'uses' => 'ArticleController@read'
    ]);
    $router->delete('/{themeSlug}/{articleSlug}', [
        'middleware' => 'auth',
        'as' => 'article_delete', 'uses' => 'ArticleController@delete'
    ]);
});

$router->group(['prefix' => 'security'], function () use ($router) {
   $router->get('/login', [
       'as' => 'login', 'uses' => 'SecurityController@login'
   ]);
    $router->post('/login', [
        'as' => 'login', 'uses' => 'SecurityController@login'
    ]);
    $router->get('/logout', [
        'as' => 'logout', 'uses' => 'SecurityController@logout'
    ]);
});
