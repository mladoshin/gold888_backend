<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    protected $fillable = [
        'start_shift', //Начало смены
        'end_shift', //конец смены
        'refreshment', //Подкрепление
        'deposit', //Залог
        'renewal', //Продление
        'partial_redemption', //Частичный выкуп
        'interest_income',  // доход за проценты
        'return_goods', //Возврат товаров
        'deposit_tickets', //Залоговые билеты/товары
        'investor_capital', ///Заёмный капитал инвесторов
        'equity', //Собственный капитал на руках
        'fixed_flow', //Фиксированный расход
        'collection', //Инкасация
        'ransom', //Выкуп
        'withdraw_pledges', //Вывод из залогов
        'selling_goods', //Продажа товаров
        'income_goods', // доход за товары // продано в товарах
        'used_goods', //Товары бу
        'pledge_tickets', //Залоговые билеты/готов к продаже
        'borrowed_capital', //Заёмный капитал кредит
        'own_capital', //  Собственный капитал в товарах
        'smart_start_shift',
        'smart_end_shift',
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
        'smart_buying_up', // скупка
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
