<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Games;
class Users extends Model
{
    use HasApiTokens;
    protected $fillable= [
        'id','username', 'password',
    ];

   protected $hidden = [
        'password'
    ];
    public function games(){
        return $this->hasMany(Games::class, 'created_by');
    }
}
