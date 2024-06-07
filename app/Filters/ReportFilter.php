<?php

namespace App\Filters;

class ReportFilter
{
    public function handle($items, $params)
    {
        if (isset($params['sum_own_capital'])){
            $items = $items->filter(function ($item) use ($params) {
                return $item['sum_own_capital'] <= $params['sum_own_capital'];
            });
        }

        if (isset($params['sum_equity'])){
            $items = $items->filter(function ($item) use ($params) {
                return $item['sum_equity'] <= $params['sum_equity'];
            });
        }

        if (isset($params['consumptions_sum_sum'])){
            $items = $items->filter(function ($item) use ($params) {
                return $item['consumptions_sum_sum'] <= $params['consumptions_sum_sum'];
            });
        }

        if (isset($params['net_profit'])){
            $items = $items->filter(function ($item) use ($params) {
                return $item['net_profit'] <= $params['net_profit'];
            });
        }

        if (isset($params['sum_income_goods'])){
            $items = $items->filter(function ($item) use ($params) {
                return $item['sum_income_goods'] <= $params['sum_income_goods'];
            });
        }

        if (isset($params['created_at'])){
            $items = $items->filter(function ($item) use ($params) {
                return date('Y-m-d', strtotime($item['created_at'])) <= $params['created_at'];
            });
        }

        return $items;
    }
}
