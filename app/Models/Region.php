<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Region extends Model
{
    protected $fillable = [
        'user_id', //(director)
        'name',
    ];

    public function director(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
