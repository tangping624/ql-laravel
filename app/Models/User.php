<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $dateFormat = 'U';
    protected $fillable   = ['mobile', 'password', 'nick_name'];
    protected $hidden     = ['password', 'remember_token'];
    protected $dates      = ['deleted_at', 'created_at', 'updated_at'];
}
