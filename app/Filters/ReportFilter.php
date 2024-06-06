<?php

namespace App\Filters;

class ReportFilter
{
    public function handle($items, $params)
    {
        if (isset($params['own_capital'])){
            $items = $items->filter(function ($item) use ($params) {
                return $item['sum_own_capital'] <= $params['own_capital'];
            });
        }

        if (isset($params['equity'])){
            $items = $items->filter(function ($item) use ($params) {
                return $item['sum_equity'] <= $params['equity'];
            });
        }

        if (isset($params['consumptions_sum_sum'])){
            $items = $items->filter(function ($item) use ($params) {
                return $item['consumptions_sum_sum'] <= $params['consumptions_sum_sum'];
            });
        }

        if (isset($params['netProfit'])){
            $items = $items->filter(function ($item) use ($params) {
                return $item['netProfit'] <= $params['netProfit'];
            });
        }

        if (isset($params['income_goods'])){
            $items = $items->filter(function ($item) use ($params) {
                return $item['sum_income_goods'] <= $params['income_goods'];
            });
        }

        if (isset($params['created_at'])){
            $items = $items->filter(function ($item) use ($params) {
                return $item['created_at'] <= $params['created_at'];
            });
        }

        return $items;
    }
}
