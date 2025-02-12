<?php

namespace App\Service;

use App\Models\Branch;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ReportService
{
    public static function validation($request, $class = Report::class)
    {
        $periodFormat = 'd-m-Y';
        $validator = Validator::make($request->all(), [
            'city_id'=>'nullable|integer',
            'branch_id'=>'nullable|integer',
            'period' => 'nullable|string|in:last_month,last_six_months,last_year',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400);
        }
        try {
            $query = $class::query();
            if ($request->filled('city_id')) {
                $branchIds = Branch::where('city_id', $request->input('city_id'))->pluck('id');
                $query->whereIn('branch_id', $branchIds);
            }

            if ($request->filled('branch_id')) {
                $query->where('branch_id', $request->input('branch_id'));
            }

            if ($request->filled('period')) {
                $now = Carbon::now();
                switch ($request->input('period')) {
                    case 'last_month':
                        $query->where('created_at', '>=', $now->subMonth());
                        break;
                    case 'last_six_months':
                        $query->where('created_at', '>=', $now->subMonths(6));
                        $periodFormat = 'm-Y';
                        break;
                    case 'last_year':
                        $query->where('created_at', '>=', $now->subYear());
                        $periodFormat = 'm-Y';
                        break;
                }
            }
            return [
                'query' => $query,
                'periodFormat' => $periodFormat
            ];
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

}
