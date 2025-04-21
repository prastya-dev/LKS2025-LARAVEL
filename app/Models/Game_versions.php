<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Games;
use App\Models\Score;

class Game_versions extends Model
{
 protected $fillable = [
    'id',
    'game_id',
    'version',
    'storage_path',
    'created_at',
    'updated_at',
    'deleted_at',
 ];
 public function games(){
    return $this->belongsTo(Games::class, 'game_id');
   }
   public function score(){
    return $this->hasMany(Scores::class, 'game_version_id');
   }
    
}
