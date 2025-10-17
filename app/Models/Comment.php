<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // WARNING: Disabling mass assignment protection as requested.
    protected $guarded = [];

    // Relationship to Profile (Many-to-One)
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}