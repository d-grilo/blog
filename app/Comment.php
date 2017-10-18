<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = [
        'post_id',
        'author',
        'email',
        'body',
        'is_active',
        'photo'
    ];


    # This comment has many replies
    public function replies() {
        return $this->hasMany('App\CommentReply');
    }

    # This comment belongs to a post
    public function post() {
        return $this->belongsTo('App\Post');
    }




}
