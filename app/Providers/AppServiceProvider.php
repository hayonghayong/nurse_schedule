<?php

namespace App\Providers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {       
        // 本番環境(Heroku)でhttpsを強制する
        if (\App::environment('production')) {
            \URL::forceScheme('https');
        }
        // herokuデプロイ時の文字数制限
        Schema::defaultStringLength(191);
        //  管理画面用のクッキー名称、セッションテーブル名を変更する < いったんコメントアウト
        // $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        // if (strpos($uri, '/admin/') === 0 || $uri === '/admin') {
        //     config([
        //         'session.cookie' => config('const.session_cookie_admin'),
        //         'session.table' => config('const.ssession_table_admin'),
        //     ]);
        // }
    }
}
