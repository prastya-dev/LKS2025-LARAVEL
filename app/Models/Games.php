<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users;
use App\Models\Game_versions;
use App\Models\Scores;
class Games extends Model
{
   protected $fillable = [
    

'id',
'title',
'slug',
'description',
'created_by',
'created_at',
'updated_at',
'deleted_at',
   ];


   public function author(){
    return $this->belongsTo(Users::class, 'created_by');
   }
   
   public function version(){
    return $this->hasMany(Game_versions::class, 'game_id');
   }
   public function score(){
    return $this->hasMany(Scores::class, 'game_version_id');
   }
}
