<?php

use Illuminate\Http\Request;
use App\Patient;

Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

// -----はよん追記-----
// -----patients_tabel crud -----
// 病棟内患者表示
Route::get('/get','PatientsController@Allpatients');

// 患者追加
Route::post('/add','PatientsController@add'); 

// 患者削除
Route::delete('/del', 'PatientsController@destroy');