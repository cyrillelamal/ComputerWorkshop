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
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->post('/create', [
            'as' => 'theme_create', 'uses' => 'ThemeController@create'
        ]);
        $router->delete('/delete/{themeSlug}', [
            'as' => 'theme_delete', 'uses' => 'ThemeController@delete'
        ]);

    });
    $router->get('/{themeSlug}', [
        'as' => 'theme_detail', 'uses' => 'ThemeController@read'
    ]);
});

$router->group(['prefix' => 'article'], function () use ($router) {
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->post('/{themeSlug}/create', [
            'as' => 'article_create', 'uses' => 'ArticleController@create'
        ]);
        $router->put('/{themeSlug}/update/{articleSlug}', [
            'as' => 'article_update', 'uses' => 'ArticleController@update'
        ]);
        $router->delete('/{themeSlug}/delete/{articleSlug}', [
            'as' => 'article_delete', 'uses' => 'ArticleController@delete'
        ]);
    });
    $router->get('/{themeSlug}/{articleSlug}', [
       'as' => 'article_detail', 'uses' => 'ArticleController@read'
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
