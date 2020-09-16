<?php

namespace App;

// 追記
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

// class Admin extends Model
class Admin extends Authenticatable
{
    // 追記
    protected $fillable = [
        'name', 'password','login_id'
    ];
}
