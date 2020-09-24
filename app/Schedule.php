<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
  protected $guarded = ["id"];
  protected $table = 'schedules';
  // findが効かないので一旦外してます
  // protected $primaryKey = ['user_id','patient_id', 'treatment_id'];
  public $incrementing = false;
  protected $fillable = ['user_id', 'patient_id', 'treatment_id'];
  
  public function user()
  {
    return $this->belongsTo('App\user');
  }

  public function treatment()
  {
    return $this->belongsTo('App\treatment');
  }

  public function patient()
  {
    return $this->belongsTo('App\patient');
  }

}

