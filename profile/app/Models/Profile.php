<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'gender', 'hobby', 'image'];

     // Relation: Profile-এর অনেক Education থাকতে পারে
    public function educations() {
        return $this->hasMany(Education::class);
    }

    // Relation: Profile-এর অনেক Comment থাকতে পারে
    public function comments() {
        return $this->hasMany(Comment::class);
    }
}
