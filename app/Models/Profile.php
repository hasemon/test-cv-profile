<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['user_id', 'avatar', 'name', 'gender', 'hobbies'];

    public function user() { return $this->belongsTo(User::class); }
    public function educations() { return $this->hasMany(Education::class); }
    public function comments() { return $this->hasMany(Comment::class); }
}
