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

Route::get('/follow/{id}', 'FollowerController@following')->name('user.follow');

Route::group(['middleware' => ['admin']], function () {
    Route::resource('course', 'CourseController')->except(['show']);
    Route::resource('user', 'UserController')->except(['show', 'edit', 'update']);
    Route::resource('lesson', 'AdminLessonController');
    Route::resource('question', 'QuestionController');
    Route::resource('answer', 'AnswerController');
    Route::post('/answer/store', 'AnswerController@store')->name('answer.store');
    Route::resource('word', 'WordController');
    Route::post('/answer/right_answer', 'AnswerController@rightAnswer')->name('answer.right_answer');
});
Route::get('/course/{id}', 'CourseController@show')->name('course.show');
Route::get('/course/{id}/words', 'CourseController@words')->name('course.words')->middleware(['auth']);
Route::get('/course/{id}/lesson', 'CourseController@lesson')->name('course.lesson')->middleware(['auth']);
Route::get('/course/{id}/learning', 'WordLearnController@learning')->name('course.learning')->middleware(['auth']);
Route::get('/course/{id}/endlesson', 'LessonController@endLesson')->name('lesson.end_lesson')->middleware(['auth']);
Route::get('/course/{id}/result', 'LessonController@result')->name('lesson.result')->middleware(['auth']);
Route::get('/course/{id}/choose', 'UserController@chooseCourse')->name('user.choose_course');
Route::post('/learning', 'WordLearnController@wordLearning')->name('word.word_learning');

Route::post('/answersingle', 'LessonController@answerSingle')->name('lesson.answerSingle')->middleware(['auth']);
Route::post('/answermultiple', 'LessonController@answerMultiple')->name('lesson.answerMultiple')->middleware(['auth']);
Route::post('/answerfillable', 'LessonController@answerFillable')->name('lesson.answerFillable')->middleware(['auth']);

Route::get('/user/{id}', 'UserController@show')->name('user.show');
Route::get('/user/{id}/edit', 'UserController@edit')->name('user.edit');
Route::patch('/user/{id}/update', 'UserController@update')->name('user.update');
