<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected $appends = ['net_profit'];
    public function consumptions(): HasMany
    {
        return $this->hasMany(Consumption::class);
    }

    public function getProfitAttribute()
    {
        return $this->attributes['interest_income'] + $this->attributes['income_goods'];
    }

    public function getNetProfitAttribute()
    {
        return $this->attributes['interest_income'] + $this->attributes['income_goods'] - $this->consumptions->sum('sum');
    }
}
