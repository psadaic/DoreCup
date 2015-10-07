<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//CSRF Filter
Route::filter('csrf', function()
{
   $token = Request::ajax() ? Request::header('X-CSRF-Token') : Input::get('_token');
   if (Session::token() != $token) {
      throw new Illuminate\Session\TokenMismatchException;
   }
});
Route::when('*', 'csrf', array('post', 'put', 'delete'));

//Pages
Route::get('/', 'HomeController@getHome');
Route::get('statistics/{run}', 'StatisticsController@getRun');
Route::get('/servers', 'ServersController@getServers');
Route::get('admin', 'AdminController@getAdmin');
Route::get('admin/login', 'AdminController@adminLogin');
Route::get('admin/logout', 'AdminController@adminLogout');

//API
Route::post('api/data/player/num', 'PlayerController@getPlayerNum');
Route::post('api/data/statistics/{run}', 'StatisticsController@getStatistics');
Route::post('api/data/stats/total', 'StatisticsController@getStatsTotal');
Route::post('api/data/servers', 'ServersController@getServerInfo');
Route::post('api/admin/login', 'AdminController@handleLogin');
Route::post('api/admin/data/info', 'AdminController@getInfo');
Route::post('api/admin/data/runs', 'AdminController@getRuns');
Route::post('api/admin/data/username', 'AdminController@getUsername');
Route::post('api/admin/data/servers', 'AdminController@getServers');
Route::post('api/admin/data/run', 'AdminController@getRun');
Route::post('api/admin/change/info', 'AdminController@changeInfo');
Route::post('api/admin/change/username', 'AdminController@changeUsername');
Route::post('api/admin/change/password', 'AdminController@changePassword');
Route::post('api/admin/add/server', 'AdminController@addServer');
Route::post('api/admin/add/run', 'AdminController@addRun');
Route::post('api/admin/delete/server', 'AdminController@deleteServer');
Route::post('api/admin/delete/run', 'AdminController@deleteRun');