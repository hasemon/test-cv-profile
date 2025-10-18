<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Education extends Model
{
    use HasFactory;

    protected $fillable = ['profile_id','degree','institute','session','ending'];

     public function profile() {
        return $this->belongsTo(Profile::class);
    }
}
