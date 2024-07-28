<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Branch extends Model
{
    protected $fillable = [
        'region_id',
        'user_id', // (director)
        'name',
        'address',
        'kpi_day_plan',
        'kpi_month_plan',
        'kpi_year_plan',
        'kpi_day_fact',
        'kpi_month_fact',
        'kpi_year_fact',
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class)->withDefault(['name' => 'this region deleted']);
    }

    public function director(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault(['name' => 'this user deleted']);
    }
}
