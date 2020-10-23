<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  // protected $guarded = ["id"];
  // protected $table = 'tasks';
  // protected $primaryKey = ['schedule_id','patient_id', 'treatment_id'];
  // public $incrementing = false;
  // protected $fillable = ['schedule_id', 'patient_id', 'treatment_id'];
  
  public function schedule()
  {
    return $this->belongsTo('App\schedule');
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

