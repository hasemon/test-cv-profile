<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\Education;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name',
        'gender',
        'hobbies',
        'avatar',
    ];

    public function educations(){
        return $this->hasMany(Education::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
