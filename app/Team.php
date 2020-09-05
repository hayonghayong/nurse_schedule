<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    //
  protected $guarded = ["id"];
  
  public function team_users()
  {
    return $this->hasMany('App\TeamUser');
  }

  public function user()
{
return $this->belongsTo('App\User');
}

}

