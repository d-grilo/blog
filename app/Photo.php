<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'file'
    ];

    protected $uploads = '/images/';




    # Accessor
    public function getFileAttribute($photo) {
        return $this->uploads . $photo;
    }



    public function user() {
        return $this->hasOne('App\User');
    }

    public function post() {
        return $this->hasOne('App\Post');
    }





}
