<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Schedule;

class SchedulesController extends Controller
{
    // 新規スケジュール追加
    public function post(){
        // インスタンス生成
        $schedule = new Schedule;
        // ログイン中のユーザー情報を取得
        $userId = Auth::id();
        // postデータを格納
        $schedule->user_id = $userId;
        $schedule->save();
        return response()->json($schedule);
    }
}
