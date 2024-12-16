<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'region_id',
        'user_id',
        'name',
    ];

    public function director(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault(['name' => 'director deleted or not selected']);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_id')->withDefault(['name' => 'region not selected']);
    }
}
