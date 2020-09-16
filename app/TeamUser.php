<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamUser extends Model
{
  protected $guarded = ["id"];
  protected $table = 'team_users';
  protected $primaryKey = ['user_id', 'team_id'];
  public $incrementing = false;
  protected $fillable = ['user_id', 'team_id'];
  
  public function team()
  {
    return $this->belongsTo('App\Team');
  }
  
  public function users()
  {
    return $this->hasMany('App\User');
  }

}

