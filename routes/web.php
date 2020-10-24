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
// ユーザー用
Auth::routes();
// アドミン用
//Admins用ログインページ
Route::get('/admin/login','Admin\Auth\LoginController@showLoginForm')->name('admin.login.form');
//Admins用ログインボタンクリック時
Route::post('/admin/login','Admin\Auth\LoginController@login')->name('admin.login');
//Admins用ログアウトボタンクリック時
Route::post('/admin/logout','Admin\Auth\LoginController@logout')->name('admin.logout');

// ▼ログイン後はフロント側(VueRouter)で全てのルーティングを管理する：一番下に書く
// ユーザー
Route::get('/', fn() => view('index'));
// ->middleware('auth:user');
// アドミン
Route::get('/admin', fn() => view('admin'))->middleware('auth:admin');


