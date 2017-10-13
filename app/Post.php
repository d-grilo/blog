<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'body',
        'user_id',
        'category_id',
        'photo_id'
    ];


    # This post has a user
    public function user() {
        return $this->belongsTo('App\User');
    }

    # This post has a photo
    public function photo() {
        return $this->belongsTo('App\Photo');
    }

    # This post has a category
    public function category() {
        return $this->belongsTo('App\Category');
    }


}
