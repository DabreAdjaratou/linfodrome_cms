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
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/password/require-reset','User\UserController@resetPassword')->name('password.required-reset');

//authentication's route
//Route::get('/password/require-reset', function () {
//    return view('auth/passwords/require-reset');
//})->name('password.require-reset')->middleware('auth');
Auth::routes();

//Route to administrator
Route::get('/administrator', function () {
    return view('layouts/administrator/admin-panel');
})->name('administrator')->middleware('auth');
// 
//redirections
// Route::redirect('/home', 'register', 301);

// Route to Article
Route::get('article-revisions','Article\ArchiveController@revision')->name('article-revisions');
Route::resource('article-archives','Article\ArchiveController');
Route::get('articles/{article}/trash','Article\ArticleController@trash')->name('article-trash');
Route::get('articles/{article}/restore','Article\ArticleController@restore')->name('article-restore');
Route::get('articles/{article}/draft','Article\ArticleController@draft')->name('article-draft');
Route::resource('articles','Article\ArticleController');
Route::resource('article-categories','Article\CategoryController');
Route::resource('article-sources','Article\SourceController');


// Route to Billet
Route::get('billet-revisions','Billet\ArchiveController@revision')->name('billet-revisions');
Route::resource('billet-archives','Billet\ArchiveController');
Route::resource('billets','Billet\BilletController');
Route::resource('billet-categories','Billet\CategoryController');
Route::resource('billet-sources','Billet\SourceController');


// Route to Video
Route::get('video-revisions','Video\ArchiveController@revision')->name('video-revisions');
Route::resource('video-archives','Video\ArchiveController');
Route::resource('videos','Video\VideoController');
Route::resource('video-categories','Video\CategoryController');

// Route to User
Route::resource('access-levels','User\AccessLevelController');
Route::resource('actions','User\ActionController');
Route::resource('user-groups','User\GroupController');
Route::resource('resources','User\ResourceController');
Route::resource('permissions','User\PermissionController');
Route::resource('users','User\UserController');

// Route to Banner

Route::resource('banners','Banner\BannerController');
Route::resource('banner-categories','Banner\CategoryController')
;
