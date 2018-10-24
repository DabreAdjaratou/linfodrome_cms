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

//redirections
// Route::redirect('/home', 'register', 301);

// Route to Article
Route::get('article-archives/laratable','Article\ArchiveController@laratableData')->name('article-archives.laratable');
Route::get('article-archives/{article}/trash','Article\ArchiveController@putInTrash')->name('article-archives.put-in-trash');
Route::get('article-archives/{article}/restore','Article\ArchiveController@restore')->name('article-archives.restore');
Route::get('article-archives/{article}/draft','Article\ArchiveController@putInDraft')->name('article-archives.put-in-draft');
Route::get('article-archives/draft','Article\ArchiveController@inDraft')->name('article-archives.draft');
Route::get('article-archives/trash','Article\ArchiveController@inTrash')->name('article-archives.trash');
Route::resource('article-archives','Article\ArchiveController');

Route::get('articles/test','Article\ArticleController@test')->name('articles.test');
Route::get('articles/laratable','Article\ArticleController@laratableData')->name('articles.laratable');
Route::get('articles/{article}/trash','Article\ArticleController@putInTrash')->name('articles.put-in-trash');
Route::get('articles/{article}/restore','Article\ArticleController@restore')->name('articles.restore');
Route::get('articles/{article}/draft','Article\ArticleController@putInDraft')->name('articles.put-in-draft');
Route::get('articles/draft','Article\ArticleController@inDraft')->name('articles.draft');
Route::get('articles/trash','Article\ArticleController@inTrash')->name('articles.trash');
Route::resource('articles','Article\ArticleController');

Route::get('article-categories/{article_category}/trash','Article\CategoryController@putInTrash')->name('article-categories.put-in-trash');
Route::get('article-categories/{article_category}/restore','Article\CategoryController@restore')->name('article-categories.restore');
Route::get('article-categories/trash','Article\CategoryController@inTrash')->name('article-categories.trash');
Route::resource('article-categories','Article\CategoryController');

Route::get('article-sources/{article_source}/trash','Article\SourceController@putInTrash')->name('article-sources.put-in-trash');
Route::get('article-sources/{article_source}/restore','Article\SourceController@restore')->name('article-sources.restore');
Route::get('article-sources/trash','Article\SourceController@inTrash')->name('article-sources.trash');
Route::resource('article-sources','Article\SourceController');


Route::resource('article-revisions','Article\RevisionController')->only([
    'index', 'show'
]);


// Route to Billet
Route::get('billet-archives/laratable','Billet\ArchiveController@laratableData')->name('billet-archives.laratable');
Route::get('billet-archives/{billet}/trash','Billet\ArchiveController@putInTrash')->name('billet-archives.put-in-trash');
Route::get('billet-archives/{billet}/restore','Billet\ArchiveController@restore')->name('billet-archives.restore');
Route::get('billet-archives/{billet}/draft','Billet\ArchiveController@putInDraft')->name('billet-archives.put-in-draft');
Route::get('billet-archives/draft','Billet\ArchiveController@inDraft')->name('billet-archives.draft');
Route::get('billet-archives/trash','Billet\ArchiveController@inTrash')->name('billet-archives.trash');
Route::resource('billet-archives','Billet\ArchiveController');

Route::get('billets/laratable','billet\billetController@laratableData')->name('billets.laratable');
Route::get('billets/{billet}/trash','Billet\BilletController@putInTrash')->name('billets.put-in-trash');
Route::get('billets/{billet}/restore','Billet\BilletController@restore')->name('billets.restore');
Route::get('billets/{billet}/draft','Billet\BilletController@putInDraft')->name('billets.put-in-draft');
Route::get('billets/draft','Billet\BilletController@inDraft')->name('billets.draft');
Route::get('billets/trash','Billet\BilletController@inTrash')->name('billets.trash');
Route::resource('billets','Billet\BilletController');

Route::get('billet-categories/{billet_category}/trash','Billet\CategoryController@putInTrash')->name('billet-categories.put-in-trash');
Route::get('billet-categories/{billet_category}/restore','Billet\CategoryController@restore')->name('billet-categories.restore');
Route::get('billet-categories/trash','Billet\CategoryController@inTrash')->name('billet-categories.trash');
Route::resource('billet-categories','Billet\CategoryController');

Route::get('billet-sources/{billet_source}/trash','Billet\SourceController@putInTrash')->name('billet-sources.put-in-trash');
Route::get('billet-sources/{billet_source}/restore','Billet\SourceController@restore')->name('billet-sources.restore');
Route::get('billet-sources/trash','Billet\SourceController@inTrash')->name('billet-sources.trash');
Route::resource('billet-sources','Billet\SourceController');


Route::resource('billet-revisions','Billet\RevisionController')->only([
    'index', 'show'
]);

// Route to Video
Route::get('video-archives/laratable','Video\ArchiveController@laratableData')->name('video-archives.laratable');
Route::get('video-archives/{video}/trash','Video\ArchiveController@putInTrash')->name('video-archives.put-in-trash');
Route::get('video-archives/{video}/restore','Video\ArchiveController@restore')->name('video-archives.restore');
Route::get('video-archives/{video}/draft','Video\ArchiveController@putInDraft')->name('video-archives.put-in-draft');
Route::get('video-archives/draft','Video\ArchiveController@inDraft')->name('video-archives.draft');
Route::get('video-archives/trash','Video\ArchiveController@inTrash')->name('video-archives.trash');
Route::resource('video-archives','Video\ArchiveController');

Route::get('videos/laratable','Video\VideoController@laratableData')->name('videos.laratable');
Route::get('videos/{video}/trash','Video\VideoController@putInTrash')->name('videos.put-in-trash');
Route::get('videos/{video}/restore','Video\VideoController@restore')->name('videos.restore');
Route::get('videos/{video}/draft','Video\VideoController@putInDraft')->name('videos.put-in-draft');
Route::get('videos/draft','Video\VideoController@inDraft')->name('videos.draft');
Route::get('videos/trash','Video\VideoController@inTrash')->name('videos.trash');
Route::resource('videos','Video\VideoController');
Route::get('video-categories/{video_category}/trash','Video\CategoryController@putInTrash')->name('video-categories.put-in-trash');
Route::get('video-categories/{video_category}/restore','Video\CategoryController@restore')->name('video-categories.restore');
Route::get('video-categories/trash','Video\CategoryController@inTrash')->name('video-categories.trash');

Route::resource('video-categories','Video\CategoryController');

Route::resource('video-revisions','Video\RevisionController')->only([
	'index', 'show'
]);

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
Route::get('banners/{banner}/trash','Banner\BannerController@putInTrash')->name('banners.put-in-trash');
Route::get('banners/{banner}/restore','Banner\BannerController@restore')->name('banners.restore');
Route::get('banners/trash','Banner\BannerController@inTrash')->name('banners.trash');
Route::resource('banners','Banner\BannerController');
Route::get('banner-categories/{banner_category}/trash','Banner\CategoryController@putInTrash')->name('banner-categories.put-in-trash');
Route::get('banner-categories/{banner_category}/restore','Banner\CategoryController@restore')->name('banner-categories.restore');
Route::get('banner-categories/trash','Banner\CategoryController@inTrash')->name('banner-categories.trash');
Route::resource('banner-categories','Banner\CategoryController');



//Route to media
Route::get('media','Media\MediaController@index')->name('media')->middleware('auth','activeUser');
Route::get('/media-to-load/{media}',function () {
 return view('media/administrator/media-to-load');
})->name('media-to-load')->middleware('auth','activeUser');