<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
  protected $guarded = ["id"];
  protected $table = 'schedules';
  
  public function users_patients()
  {
    return $this->hasMany('App\UsersPatient');
  }

  public function user()
    {
    return $this->belongsTo('App\User');
    }

}
