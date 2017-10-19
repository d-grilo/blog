<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;


class Post extends Model implements SluggableInterface
{

    use SluggableTrait;

    protected $sluggable = [
        'build_from'=> 'title',
        'save_to'=>'slug',
        'on_update'=>true
    ];


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


    # This post has many comments
    public function comments() {
        return $this->hasMany('App\Comment');
    }


}
