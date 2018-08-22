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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Route to Article
Route::resource('article-archives','Article\ArchiveController');
Route::resource('articles','Article\ArticleController');
Route::resource('article-categories','Article\CategoryController');
Route::resource('article-revisions','Article\RevisionController');
Route::resource('sources','Article\SourceController');


// Route to Billet
Route::resource('billet-archives','Billet\ArchiveController');
Route::resource('billets','Billet\BilletController');
Route::resource('billet-categories','Billet\CategoryController');
Route::resource('billet-revisions','Billet\RevisionController');


// Route to Video
Route::resource('video-archives','Video\ArchiveController');
Route::resource('videos','Video\VideoController');
Route::resource('video-categories','Video\CategoryController');
Route::resource('video-revisions','Video\RevisionController');

// Route to User
Route::resource('access-levels','User\AccessLevelController');
Route::resource('actions','User\ActionController');
Route::resource('user-groups','User\GroupController');
Route::resource('resources','User\ResourceController');
Route::resource('users','User\UserController');