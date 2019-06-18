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


/*
Route::get('/hello', function () {
    return "<h1>Hello World</h1>";
});

Route::get('/users/{id}/{name}', function ($id, $name) {//Slanje promenljive preko rute nekoj strani
    return "This is user id: ".$id." and name: ".$name;
});

Route::get('/about', function () {
    return view('pages.about');
});


Route::get('/', function () {
    return view('home');
});
*/

Route::get('/', "PagesController@index");
//Route::get('/userList', "PagesController@userList");
Route::resource('/userList', "UpdateUserController");

Route::get('/about', "PagesController@about");
Route::get('/services', "PagesController@services");
Route::get('/startit', "PagesController@startit");

Route::post('/profile/{id}', "PostsController@store");

Route::resource("posts", "PostsController");
//Route::resource("posts", "PostsController")->middleware("can:checkIfAuthorized,post");


Route::patch('/posts/{id}/comments/{comment_id}', "CommentsController@softDelete");
Route::get('/posts/{id}/comments/{comment_id}', "CommentsController@softUnDelete");
Route::post('/posts/{id}/comments/{comment_id}', "CommentsController@update");
Route::resource("/posts/{id}/comments", "CommentsController");

Route::post('/posts/{post_id}/{user_id}', "LikesController@addLikes");

//Route::resource("/posts/{id}/comments/{parent_id}", "CommentsController");

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
Route::get('/profile/{id}', 'ProfileController@show');
//Route::post('/profile/{id}', 'ProfileController@store');

Route::post('/posts', "PostsController@ajax");