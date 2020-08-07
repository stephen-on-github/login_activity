<?php

use Illuminate\Support\Facades\Route;

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

// Main page for the app. Display the login activity chart.
Route::get('/', 'siteController@loginActivity')->name('loginActivity');

// API URL for fetching login activity data.
Route::get('/api/logins', 'siteController@loginActivityApi')->name('loginActivityApi');
