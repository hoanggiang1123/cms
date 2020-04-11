<?php

use Illuminate\Support\Facades\Route;

$prefixAdmin = config('hgcms.url.prefix_admin');
$prefixBlog = config('hgcms.url.prefixBlog');

Route::group(['prefix' => $prefixAdmin, 'namespace' => 'Admin'], function() {

    //========================= DASHBOARD ================================
    $prefix = 'dashboard';
    $controllerName = 'dashboard';
    Route::group(['prefix' => $prefix], function () use($controllerName) {
        $controller = ucfirst($controllerName).'Controller@';
        Route::get('/',['as' => $controllerName, 'uses' => $controller. 'index']);
    });

    //========================= POSTS ================================

    $prefix = 'post';
    $controllerName = 'post';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName).'Controller@';
        Route::get('/', ['as' => $controllerName, 'uses' => $controller.'index']);
        Route::post('change-status-multi/{status}', ['as' => $controllerName.'/statuses', 'uses' => $controller.'statuses']);
        Route::get('change-status-{status}/{id}', ['as' => $controllerName.'/status', 'uses' => $controller.'status']);
        Route::get('form/{id?}', ['as' => $controllerName.'/form', 'uses' => $controller.'form']);
        Route::post('delete-multi', ['as' => $controllerName.'/deletes', 'uses' => $controller.'deletes']);
        Route::get('delete-{id}',['as'=> $controllerName.'/delete','uses'=> $controller.'delete']);
        Route::post('save',['as' => $controllerName.'/save', 'uses' => $controller.'save']);
        // Route::post('upload',['as' => $controllerName.'/upload', 'uses' => $controller.'upload']);
    });

    //========================= MEDIA ================================

    $prefix = 'media';
    $controllerName = 'media';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName).'Controller@';
        Route::get('/list', ['as' => $controllerName.'/list', 'uses' => $controller.'list']);
        Route::post('upload', ['as' => $controllerName.'/upload', 'uses' => $controller.'upload']);
        Route::post('save', ['as' => $controllerName.'/save', 'uses' => $controller.'save']);
        Route::post('delete', ['as' => $controllerName.'/delete', 'uses' => $controller.'delete']);
    });

    //========================= CATEGORY ================================

    $prefix = 'category';
    $controllerName = 'category';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName).'Controller@';
        Route::get('/', ['as' => $controllerName, 'uses' => $controller.'index']);
        Route::get('form/{id?}', ['as' => $controllerName.'/form', 'uses' => $controller.'form']);
        Route::get('delete-{id}',['as'=> $controllerName.'/delete','uses'=> $controller.'delete']);
        Route::post('delete-multi', ['as' => $controllerName.'/deletes', 'uses' => $controller.'deletes']);
        Route::post('change-status-multi/{status}', ['as' => $controllerName.'/statuses', 'uses' => $controller.'statuses']);
        Route::get('change-status-{status}/{id}', ['as' => $controllerName.'/status', 'uses' => $controller.'status']);
        Route::post('change-ishome-multi/{ishome}', ['as' => $controllerName.'/ishomese', 'uses' => $controller.'ishomese']);
        Route::get('change-ishome-{ishome}/{id}', ['as' => $controllerName.'/ishome', 'uses' => $controller.'ishome']);
        Route::post('display', ['as' => $controllerName.'/display', 'uses' => $controller.'display']);
        Route::post('ordering', ['as' => $controllerName.'/ordering', 'uses' => $controller.'ordering']);
        Route::post('save',['as' => $controllerName.'/save', 'uses' => $controller.'save']);
    });


    //========================= TAG ================================

    $prefix = 'tag';
    $controllerName = 'tag';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName).'Controller@';
        Route::get('/', ['as' => $controllerName, 'uses' => $controller.'index']);
        Route::get('form/{id?}', ['as' => $controllerName.'/form', 'uses' => $controller.'form']);
        Route::get('delete-{id}',['as'=> $controllerName.'/delete','uses'=> $controller.'delete']);
        Route::post('delete-multi', ['as' => $controllerName.'/deletes', 'uses' => $controller.'deletes']);
        Route::post('change-status-multi/{status}', ['as' => $controllerName.'/statuses', 'uses' => $controller.'statuses']);
        Route::get('change-status-{status}/{id}', ['as' => $controllerName.'/status', 'uses' => $controller.'status']);
        Route::post('change-ishome-multi/{ishome}', ['as' => $controllerName.'/ishomese', 'uses' => $controller.'ishomese']);
        Route::get('change-ishome-{ishome}/{id}', ['as' => $controllerName.'/ishome', 'uses' => $controller.'ishome']);
        Route::post('display', ['as' => $controllerName.'/display', 'uses' => $controller.'display']);
        Route::post('ordering', ['as' => $controllerName.'/ordering', 'uses' => $controller.'ordering']);
        Route::post('save',['as' => $controllerName.'/save', 'uses' => $controller.'save']);
    });


    //========================= USER ================================

    $prefix = 'user';
    $controllerName = 'user';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName).'Controller@';
        Route::get('/', ['as' => $controllerName, 'uses' => $controller.'index']);
        Route::get('form/{id?}', ['as' => $controllerName.'/form', 'uses' => $controller.'form']);
        Route::get('delete-{id}',['as'=> $controllerName.'/delete','uses'=> $controller.'delete']);
        Route::post('delete-multi', ['as' => $controllerName.'/deletes', 'uses' => $controller.'deletes']);
        Route::post('change-status-multi/{status}', ['as' => $controllerName.'/statuses', 'uses' => $controller.'statuses']);
        Route::get('change-status-{status}/{id}', ['as' => $controllerName.'/status', 'uses' => $controller.'status']);
        Route::post('change-ishome-multi/{ishome}', ['as' => $controllerName.'/ishomese', 'uses' => $controller.'ishomese']);
        Route::get('change-ishome-{ishome}/{id}', ['as' => $controllerName.'/ishome', 'uses' => $controller.'ishome']);
        Route::post('display', ['as' => $controllerName.'/display', 'uses' => $controller.'display']);
        Route::post('ordering', ['as' => $controllerName.'/ordering', 'uses' => $controller.'ordering']);
        Route::post('save',['as' => $controllerName.'/save', 'uses' => $controller.'save']);
        Route::post('change-password',['as' => $controllerName.'/change-password', 'uses' => $controller.'changePassword']);
        Route::post('change-level',['as' => $controllerName.'/level', 'uses' => $controller.'level']);
    }); 


    //========================= GROUP ================================

    $prefix = 'group';
    $controllerName = 'group';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName).'Controller@';
        Route::get('/', ['as' => $controllerName, 'uses' => $controller.'index']);
        Route::get('form/{id?}', ['as' => $controllerName.'/form', 'uses' => $controller.'form']);
        Route::get('delete-{id}',['as'=> $controllerName.'/delete','uses'=> $controller.'delete']);
        Route::post('save',['as' => $controllerName.'/save', 'uses' => $controller.'save']);
    });
    

    //========================= AUTH ================================


    $prefix = 'auth';
    $controllerName = 'auth';
    Route::group(['prefix' => $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName).'Controller@';
        Route::get('/login', ['as' => $controllerName. '/login', 'uses' => $controller.'login'])->middleware('check.login');
        Route::post('/postLogin', ['as' => $controllerName. '/postLogin', 'uses' => $controller.'postLogin']);
        Route::get('/logout', ['as' => $controllerName. '/logout', 'uses' => $controller.'logout']);
    });
});