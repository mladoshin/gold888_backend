<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    protected $fillable = [
        'start_shift',
        'refreshment',
        'deposit',
        'renewal',
        'partial_redemption',
        'interest_income',
        'return_goods',
        'deposit_tickets',
        'investor_capital',
        'equity',
        'fixed_flow',
        'collection',
        'ransom',
        'withdraw_pledges',
        'selling_goods',
        'income_goods',
        'used_goods',
        'pledge_tickets',
        'borrowed_capital',
        'own_capital',
        'report_type',
    ];

    public function consumptions(): HasMany
    {
        return $this->hasMany(Consumption::class);
    }
}
