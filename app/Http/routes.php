<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
// Route::resource('/home', 'HomeController');
// Route::get('/home',function(){
//   return view('welcome');
// });
//
Route::get('/', 'IndexController@index');
Route::group(['prefix'=>'user','middleware'=>['auth']],function(){
  route::resource('profile','ProfileController');
});
Route::group(['middleware'=>['auth','Entrust']],function(){
	Route::resource('albums', 'AlbumController');
	Route::resource('photos', 'PhotoController');
	Route::resource('upload','UploadController');
	Route::resource('softs','SoftController');
});
Route::get('softs','SoftController@index');
Route::group(['prefix'=>'admin','middleware'=>['auth','Entrust']],function(){
  route::resource('roles','Entrust\RoleController');
  route::resource('permissions','Entrust\PermissionController');
  route::resource('users','Entrust\UserController');
});
// 认证路由...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
// 注册路由...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');