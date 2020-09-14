<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamUser extends Model
{
  protected $guarded = ["id"];
  
  public function team()
  {
    return $this->belongsTo('App\Team');
  }
  
  public function users()
  {
    return $this->hasMany('App\User');
  }

}

