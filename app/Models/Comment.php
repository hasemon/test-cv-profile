<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['profile_id','commenter_name','comment','image'];

    public function profile() {
        return $this->belongsTo(Profile::class);
    }
}
