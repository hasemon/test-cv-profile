<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(UserInfo::class);
    }

    public function getCommentImageAttribute()
    {
        return $this->attributes['comment_image'] ? asset('storage/' . $this->attributes['comment_image']) : null;
    }
}
