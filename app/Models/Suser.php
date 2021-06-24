<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Suser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded=['ID'];

    protected $fillable = [
        'nick',
        'email',
        'password',
        'role'
    ];
    protected $hidden = [
        'password',
    ];

    protected $attributes = [
        'role' => 0,
    ];

    function entries(){
        return $this->hasMany(Entry::class, 'user_id', 'ID');
    }

    public function getAuthPassword()
    {
        return $this->password;
    }
}
