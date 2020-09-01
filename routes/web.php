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


// ▼Authのルーティング:一番上に書く
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// ▼ログイン後はフロント側(VueRouter)で全てのルーティングを管理する：一番下に書く
Route::get('/{any?}', fn() => view('index'))->where('any', '.+')->middleware('auth');

