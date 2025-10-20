<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    // WARNING: Disabling mass assignment protection as requested.
    protected $guarded = [];

    // Relationship to Education (One-to-Many)
    public function education()
    {
        return $this->hasMany(Education::class);
    }

    // Relationship to Comments (One-to-Many)
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}