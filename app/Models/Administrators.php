<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Administrators extends Model
{
    use HasApiTokens;
    protected $fillable= [
        'id','username', 'password',
    ];
}
