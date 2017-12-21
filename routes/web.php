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

// Users endpoints

Route::post('/createuser', 'UserController@CreateUser');

Route::post('/login', 'LoginController@LoginUser');

Route::post('/logout', 'LoginController@LogoutUser');

Route::post('/getuserbyid', 'UserController@GetUserById');

// Experiences endpoints

Route::post('/createexperience', 'ExperienceController@CreateExperience');

Route::post('/getuserexperiences', 'ExperienceController@GetExperiencesByUser');

// Trips endpoints

Route::post('/createtrip', 'TripController@CreateTrip');

Route::post('/addexperiencetotrip', 'TripController@AddToExistingTrip');

Route::post('/getUserTrips', 'TripController@GetUserTrips');

// Vue route catcher

Route::post('/addcomment', 'CommentsController@AddComment');

Route::get('/funkytown', 'ProfileController@GetProfileFeed');

Route::get('/{vue_capture?}', 'Controller@GetFrontpage')->where('vue_capture', '[\/\w\.-]*');
