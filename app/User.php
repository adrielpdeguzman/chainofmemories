<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the journals of the user
     *
     * @return  Illuminate\Database\Eloquent\hasMany
     */
    public function journals()
    {
        return $this->hasMany('App\Journal');
    }

    /**
     * Configure passport to use 'username' as username
     *
     * @param   string  $username
     *
     * @return  User
     */
    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }
}
