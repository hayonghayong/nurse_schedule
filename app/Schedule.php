<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
  protected $guarded = ["id"];
  
  public function treatment()
  {
    return $this->belongsTo('App\treatment');
  }

  public function patient()
  {
    return $this->belongsTo('App\patient');
  }

}

