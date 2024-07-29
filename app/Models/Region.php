<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    protected $fillable = [
        'user_id', //(director)
        'name',
    ];

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function director(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault(['name' => 'user deleted or not selected']);
    }
}
