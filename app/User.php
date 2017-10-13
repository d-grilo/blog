<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'role_id',
        'is_active',
        'photo_id',
        'email',
        'password'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role() {
        return $this->belongsTo('App\Role');
    }


    public function photo() {
        return $this->belongsTo('App\Photo');
    }

    # This user has many posts
    public function posts() {
        return $this->hasMany('App\Post');
    }


    public function isAdmin() {

        if($this->role->name == 'administrator' && $this->is_active == 1)
            return true;
        else
            return false;

    }


}
