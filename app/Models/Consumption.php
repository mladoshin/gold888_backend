<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumption extends Model
{
    use HasFactory;
    protected $fillable = [
        'report_id',
        'sum',
        'description',
        'type',
        'report_type',
    ];

    protected $attributes = ['report_type' => 'express'];
}
