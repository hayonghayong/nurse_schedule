<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Treatment extends Model
{
  protected $guarded = ["id"];
  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $fillable = ['body'];

  public function tasks()
  {
    return $this->hasMany('App\Task');
  }


}

