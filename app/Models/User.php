<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'users';
    protected $fillable = [
        'email',
        'password',
        'google_id',
        'google_token',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public $timestamps = true;
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }
    public function isLoggedInWithGoogle()
    {
        return !is_null($this->google_id);
    }
    public function userInformation()
    {
        return $this->hasOne(UserInformation::class, 'user_id', 'id');
    }
}