<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInfo extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'hobbies' => 'array',
        'education_information' => 'array',
        'education' => 'array',
    ];
}
