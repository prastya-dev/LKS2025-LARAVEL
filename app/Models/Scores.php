<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users;
class Scores extends Model
{
    

  protected $fillable = [
    'user_id',
    'game_version_id',
    'score'
  ];


   public function user(){
    return $this->belongsTo(Users::class, 'user_id');
   }
    

}
