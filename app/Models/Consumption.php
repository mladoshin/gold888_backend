<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consumption extends Model
{
    protected $fillable = [
        'report_id',
        'sum',
        'description',
        'type',
    ];
}
