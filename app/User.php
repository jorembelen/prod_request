<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'provider', 'provider_id', 'password',
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationship with roles
	public function role()
	{
		return $this->belongsToMany('App\Role', 'user_roles', 'user_id', 'role_id');
    }

    /**
     * Get the user role slug
     */
    public function getRoleNameAttribute()
    {
        return auth()->user()->role->first()->name;
    }

    public function jobseeker()
    {
        return $this->hasOne('App\Jobseeker', 'user_id', 'id');
    }
}
