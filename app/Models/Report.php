<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    protected $fillable = [
        'region_id',
        'branch_id',
        'user_id',
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
        'refreshment_text',
        'collection_text',

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
        'smart_collection_text',
        'smart_refreshment_text'
    ];

    protected $appends = ['net_profit', 'sum_equity', 'sum_own_capital', 'sum_income_goods', 'sum_start_shift', 'sum_end_shift', 'sum_deposit_tickets'];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_id')->withDefault(['name' => 'this region deleted']);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault(['name' => 'this user deleted']);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id')->withDefault(['name' => 'this branch deleted']);
    }

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

    public function getSumStartShiftAttribute()
    {
        return $this->attributes['start_shift'] + $this->attributes['smart_start_shift'];
    }

    public function getSumEndShiftAttribute()
    {
        return $this->attributes['end_shift'] + $this->attributes['smart_end_shift'];
    }

    public function getSumIncomeGoodsAttribute()
    {
        return $this->attributes['income_goods'] + $this->attributes['smart_income_goods'];
    }

    public function getSumDepositTicketsAttribute()
    {
        return $this->attributes['deposit_tickets'] + $this->attributes['smart_deposit_tickets'];
    }

    public function getNetProfitAttribute()
    {
        return $this->attributes['interest_income'] + $this->attributes['income_goods'] + $this->attributes['smart_interest_income'] + $this->attributes['smart_income_goods'] - $this->consumptions->sum('sum');
    }

    public static function boot(): void
    {
        parent::boot();
        static::saving(function($item) {
            $item->user_id = request()->user()->id;
            $item->branch_id = request()->user()->branch_id;
            $item->region_id = request()->user()->branch->region_id;
        });
    }

}
