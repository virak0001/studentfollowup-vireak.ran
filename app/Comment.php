<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function student(){
        return $this->belongsTo('App\Student');
    }
}
