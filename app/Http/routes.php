<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'Home\IndexController@index');
Route::get('/cate/{cate_id}', 'Home\IndexController@cate');
Route::get('/a/{art_id}', 'Home\IndexController@article');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::any('admin/login','Admin\LoginController@login');
    Route::get('admin/code','Admin\LoginController@code');
});
Route::group(['middleware' => ['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'], function () {
    Route::get('/','IndexController@index');
    Route::get('info','IndexController@info');
    Route::get('quit','LoginController@quit');
    Route::any('pass','IndexController@pass');

    //文章分类的增删该查
    Route::any('cate/changeorder','CategoryController@changeOrder');
    Route::resource('category','CategoryController');

    //文章管理的增删改查
    Route::resource('article','ArticleController');
    //图片上传路由
    Route::any('upload','CommonController@upload');

    //友情链接路由
    Route::any('links/changeorder','LinksController@changeOrder');
    Route::resource('links','LinksController');

    //自定义导航
    Route::post('navs/changeorder','NavsController@changeOrder');
    Route::resource('navs','NavsController');

    //配置项路由
    Route::get('config/putfile','ConfigController@putFile');//需要卸载资源路由前面，否则和show方法冲突
    Route::post('config/changeorder','ConfigController@changeOrder');
    Route::resource('config','ConfigController');
    Route::post('config/changecontent','ConfigController@changeContent');

});
