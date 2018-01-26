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

Route::get('/','HomeController@index')->name('home');
Route::get('login', 'Users@login');
Route::get('review', 'HomeController@reviewToday')->name('reviewToday');
Route::post('answers', 'HomeController@saveSurvey');

Auth::routes();
