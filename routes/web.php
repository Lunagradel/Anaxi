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

Route::get('/mongo', 'UserController@GetUsers');

Route::post('/createuser', 'UserController@CreateUser');

Route::post('/login', 'LoginController@LoginUser');

Route::post('/logout', 'LoginController@LogoutUser');

Route::post('/createexperience', 'ExperienceController@CreateExperience');

Route::post('/getuserexperiences', 'ExperienceController@GetExperiencesByUser');

Route::post('/createtrip', 'TripController@CreateTrip');

Route::post('/getuserbyid', 'UserController@GetUserById');

Route::get('/{vue_capture?}', 'Controller@GetFrontpage')->where('vue_capture', '[\/\w\.-]*');