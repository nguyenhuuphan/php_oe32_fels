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

Route::get('/home', 'CourseController@index');
Route::get('/course', 'CourseController@index');
Route::get('/', 'CourseController@index')->name('home');

Route::view('/terms-of-use', 'layout.static_pages.terms')->name('static_pages.terms');
Route::view('/privacy-policy', 'layout.static_pages.privacy_policy')->name('static_pages.privacy_policy');
Route::view('/about', 'layout.static_pages.about')->name('static_pages.about');

Auth::routes();

Route::get('/redirect/{social}', 'Auth\AuthSocialController@redirect')->name('redirect_social');
Route::get('/callback/{social}', 'Auth\AuthSocialController@callback');

Route::get('/dashboard', 'UserController@index')->name('user.dashboard');
Route::get('/follow/{id}', 'UserController@following')->name('user.follow');
Route::get('/course/{id}/choose', 'UserController@chooseCourse')->name('user.choose_course');
Route::post('/learn/{id}', 'WordLearnController@wordLearn')->name('user.word_learn');

Route::group(['middleware' => ['admin']], function () {
    Route::resource('course', 'CourseController')->except(['show', 'words']);
});
Route::get('/course/{id}', 'CourseController@show')->name('course.show');
Route::get('/course/{id}/words', 'CourseController@words')->name('course.words')->middleware(['auth', 'CheckCourse']);
Route::get('/course/{id}/lesson', 'CourseController@lesson')->name('course.lesson')->middleware(['auth', 'CheckCourse']);

Route::post('/answer', 'LessonController@answer')->name('lesson.answer')->middleware(['auth']);
Route::get('/course/{id}/endlesson', 'LessonController@endLesson')->name('lesson.end_lesson')->middleware(['auth']);

Route::get('/profile/{id}', 'UserController@profile')->name('profile');
Route::get('/profile/update', 'UserController@edit')->name('profile.edit');
Route::patch('/profile/update', 'UserController@update')->name('profile.update');
