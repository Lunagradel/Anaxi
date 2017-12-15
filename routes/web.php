<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Controller@GetFrontpage');

Route::get('/mongo', 'Controller@GetUsers');

Route::post('/createuser', 'Controller@CreateUser');

Route::post('/login', 'LoginController@LoginUser');
Route::get('/logout', 'LoginController@LogoutUser');

Route::get('/{vue_capture?}', function () {
	return view('welcome');
})->where('vue_capture', '[\/\w\.-]*');