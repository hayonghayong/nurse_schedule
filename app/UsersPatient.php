<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersPatient extends Model
{
  // protected $guarded = ["id"];
  // protected $table = 'users_patients';
  // protected $primaryKey = ['schedule_id','patient_id'];
  // public $incrementing = false;
  // protected $fillable = ['schedule_id','patient_id'];

  public function schedule()
  {
    return $this->belongsTo('App\Schedule');
  }

  public function patient()
  {
    return $this->belongsTo('App\Patient');
  }

}

