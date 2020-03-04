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

Route::get('/home', 'CourseController@index')->name('home');

Route::get('/', 'CourseController@index')->name('home');

Route::view('/terms-of-use', 'layout.static_pages.terms')->name('static_pages.terms');
Route::view('/privacy-policy', 'layout.static_pages.privacy_policy')->name('static_pages.privacy_policy');
Route::view('/about', 'layout.static_pages.about')->name('static_pages.about');

Auth::routes();

Route::get('/redirect/{social}', 'Auth\AuthSocialController@redirect')->name('redirect_social');
Route::get('/callback/{social}', 'Auth\AuthSocialController@callback');

Route::group(['middleware' => ['admin']], function () {
    Route::resource('course', 'CourseController')->except(['show']);
});

Route::get('/course/{id}', 'CourseController@show')->name('course.show');
Route::get('/dashboard', 'UserController@index')->name('user.dashboard');

Route::get('/profile/{id}', 'UserController@profile')->name('profile');
Route::get('/profile/update', 'UserController@edit')->name('profile.edit');
Route::patch('/profile/update', 'UserController@update')->name('profile.update');
