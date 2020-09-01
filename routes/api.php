<?php

use Illuminate\Http\Request;
use App\Patient;

Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

// ログイン認証後に使用できるAPI <最終的には全てこのgroupの中に記載します
Route::group(['middleware' => 'auth'], function () {
  // -----users_tabel crud -----
  // ログイン中のユーザー情報取得
  Route::get('user/fetch', 'Api\UsersController@show');

});


// -----はよん追記-----
// -----patients_tabel crud -----
// 患者一覧表示
Route::get('/allPatient','PatientsController@Allpatients');

// 患者追加
Route::post('/add','PatientsController@add'); 

// 患者削除
Route::delete('/delPatient', 'PatientsController@destroy');

// 更新する患者取得
Route::get('/getPatient/{patient}','PatientsController@editPatient');

// 患者更新
Route::post('/updatePatient/{editPatient}','PatientsController@updatePatient');