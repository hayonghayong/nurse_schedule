<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
  protected $guarded = ["id"];
  
  public function treatments()
  {
    return $this->belongsToMany('App\treatment');
  }

  public function patients()
  {
    return $this->belongsToMany('App\patient');
  }

}

