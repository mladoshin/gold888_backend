<?php

namespace App\Models;

use Carbon\Carbon;
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
        'income_goods', // доход за товары // продано в товарах
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

    protected $appends = ['net_profit', 'sum_equity', 'sum_own_capital', 'sum_income_goods'];
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
    public function consumptions(): HasMany
    {
        return $this->hasMany(Consumption::class);
    }

    public function getSumEquityAttribute()
    {
        return $this->attributes['equity'] + $this->attributes['smart_equity'];
    }

    public function getSumOwnCapitalAttribute()
    {
        return $this->attributes['own_capital'] + $this->attributes['smart_own_capital'];
    }

    public function getSumIncomeGoodsAttribute()
    {
        return $this->attributes['income_goods'] + $this->attributes['smart_income_goods'];
    }

    public function getNetProfitAttribute()
    {
        return $this->attributes['interest_income'] + $this->attributes['income_goods'] + $this->attributes['smart_interest_income'] + $this->attributes['smart_income_goods'] - $this->consumptions->sum('sum');
    }
}
