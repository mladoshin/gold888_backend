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
        'interest_income',  // доход за проценты
        'return_goods',
        'deposit_tickets',
        'investor_capital',
        'equity',
        'fixed_flow',
        'collection',
        'ransom',
        'withdraw_pledges',
        'selling_goods',
        'income_goods', // доход за товары
        'used_goods',
        'pledge_tickets',
        'borrowed_capital',
        'own_capital',
        'smart_start_shift',
        'smart_refreshment',
        'smart_deposit',
        'smart_renewal',
        'smart_partial_redemption',
        'smart_interest_income',
        'smart_return_goods',
        'smart_deposit_tickets',
        'smart_investor_capital',
        'smart_equity',
        'smart_fixed_flow',
        'smart_collection',
        'smart_ransom',
        'smart_withdraw_pledges',
        'smart_selling_goods',
        'smart_income_goods',
        'smart_used_goods',
        'smart_pledge_tickets',
        'smart_borrowed_capital',
        'smart_own_capital',
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
