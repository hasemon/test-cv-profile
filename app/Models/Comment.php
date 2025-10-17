<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'profile_id',
        'commenter_name',
        'text',
        'image',
    ];

    public function profile(){
        return $this->belongsTo(Profile::class);
    }
}
