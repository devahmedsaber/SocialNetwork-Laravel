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

// Home

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/alert', function(){
    return redirect()->route('home')->with('info', 'You Have Logged.');
});

// Authentication

Route::group(['middleware' => 'guest'], function(){
    Route::get('/signup', 'AuthController@getSignUp')->name('auth.signup');
    Route::post('/signup', 'AuthController@postSignUp');
    Route::get('/signin', 'AuthController@getSignIn')->name('auth.signin');
    Route::post('/signin', 'AuthController@postSignIn');
});

Route::get('/signout', 'AuthController@getSignOut')->name('auth.signout');

// Search

Route::get('/search', 'SearchController@getResults')->name('search.results');

// User Profile

Route::get('/user/{username}', 'ProfileController@getProfile')->name('profile.index');

Route::group(['middleware' => 'auth'], function(){
    Route::get('/profile/edit', 'ProfileController@getEdit')->name('profile.edit');
    Route::post('/profile/edit', 'ProfileController@postEdit');
});

// Friends

Route::get('/friends', 'FriendController@getIndex')->middleware('auth')->name('friends.index');