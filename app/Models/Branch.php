<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
