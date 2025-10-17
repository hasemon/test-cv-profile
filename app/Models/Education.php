<?php

namespace App\Models;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $fillable = [
        'profile_id',
        'degree',
        'institute',
        'start_date',
        'end_year',
    ];

    public function profile(){
        return $this->belongsTo(Profile::class);
    }

}
