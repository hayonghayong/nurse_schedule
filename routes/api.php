<?php

use Illuminate\Http\Request;
use App\Patient;

Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
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

// 担当患者登録
Route::post('/add/{userPatients}','UsersPatientsController@add'); 

// 担当患者取得
Route::get('/get','UsersPatientsController@get'); 