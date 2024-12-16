<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Overdue extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'branch_id',
        'user',
        'status',
        'amount',
        'returned',
        'result',
        'return_date'
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id')->withDefault(['name' => 'this branch deleted']);
    }

}
