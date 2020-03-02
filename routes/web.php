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

Route::view('/home', 'layout.home')->name('home');

Route::view('/', 'layout.home')->name('home');

Route::view('/about', 'layout.static_pages.about')->name('static_pages.about');
Route::view('/terms-of-use', 'layout.static_pages.terms')->name('static_pages.terms');
Route::view('/privacy-policy', 'layout.static_pages.privacy_policy')->name('static_pages.privacy_policy');
