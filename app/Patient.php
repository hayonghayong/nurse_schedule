<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
  protected $guarded = ["id"];
  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $fillable = ['body'];

  public function user()
    {
      return $this->belongsToMany('App\User');
    }

}

