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

Auth::routes();

//Route to administrator
Route::get('/administrator', function () {
    return view('layouts/administrator/admin-panel');
})->name('administrator')->middleware('auth','activeUser');
// 
//redirections
// Route::redirect('/home', 'register', 301);

// Route to Article
Route::get('article-revisions','Article\ArchiveController@revision')->name('article-revisions');
Route::get('article-archives/{article}/trash','Article\ArchiveController@putInTrash')->name('article-archives.put-in-trash');
Route::get('article-archives/{article}/restore','Article\ArchiveController@restore')->name('article-archives.restore');
Route::get('article-archives/{article}/draft','Article\ArchiveController@putInDraft')->name('article-archives.put-in-draft');
Route::get('article-archives/draft','Article\ArchiveController@articleInDraft')->name('article-archives.draft');
Route::get('article-archives/trash','Article\ArchiveController@articleInTrash')->name('article-archives.trash');
Route::resource('article-archives','Article\ArchiveController');
Route::get('articles/{article}/trash','Article\ArticleController@putInTrash')->name('articles.put-in-trash');
Route::get('articles/{article}/restore','Article\ArticleController@restore')->name('articles.restore');
Route::get('articles/{article}/draft','Article\ArticleController@putInDraft')->name('articles.put-in-draft');
Route::get('articles/draft','Article\ArticleController@articleInDraft')->name('articles.draft');
Route::get('articles/trash','Article\ArticleController@articleInTrash')->name('articles.trash');
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
Route::get('/users/{user}/reset-password','User\UserController@requireResetPassword')->name('users.require-reset');
Route::match(['put', 'patch'], '/users/{user}/update-password', 'User\UserController@resetPassword')->name('users.update-password');
Route::resource('users','User\UserController');

// Route to Banner

Route::resource('banners','Banner\BannerController');
Route::resource('banner-categories','Banner\CategoryController')
;
