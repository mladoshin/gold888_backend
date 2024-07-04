<?php

namespace App\Http\Controllers\Api;

use App\Filters\ReportFilter;
use App\Helpers\PaginateCollection;
use App\Http\Requests\StoreReportRequest;
use App\Http\Resources\ReportTableResource;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $key = $request->key;
        $reports = Report::query()
            ->select('id', 'income_goods', 'smart_income_goods', 'own_capital', 'smart_own_capital', 'equity', 'smart_equity', 'interest_income', 'smart_interest_income', 'created_at', 'start_shift', 'smart_start_shift', 'end_shift', 'smart_end_shift', 'deposit_tickets', 'smart_deposit_tickets')
            ->latest()
            ->withSum('consumptions', 'sum')
            ->when($key, function ($q) use ($key){
                $q->where('own_capital', 'like', '%'.$key.'%')
                    ->orWhere('equity', 'like', '%'.$key.'%')
                    ->orWhere('income_goods', 'like', '%'.$key.'%');
            })
        ->get();

        $reports = (new ReportFilter())->handle($reports, $request->only('sum_start_shift', 'sum_end_shift', 'sum_own_capital', 'sum_equity', 'consumptions_sum_sum', 'net_profit', 'sum_income_goods', 'created_at'));
        $paginatedData = (new PaginateCollection())->handle($reports, $request->page);
        return response()->json($paginatedData);
    }

    public function store(StoreReportRequest $request)
    {
        \DB::beginTransaction();
        try {
            $report = Report::create($request->all());
            $report->consumptions()->createMany($request->smart_consumptions ?? []);
            $report->consumptions()->createMany($request->express_consumptions ?? []);
            \DB::commit();
            return response()->json([
                'success' => true,
                'data' => []
            ]);
        }catch (\Exception $e){
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'data' => ['error' => $e->getMessage()]
            ]);
        }
    }

    public function show(Report $report)
    {
        $report = Report::withSum('consumptions', 'sum')
            ->find($report->id);
        $smartConsumptions = $report->consumptions()->where('report_type', 'smart')->get();
        $expressConsumptions = $report->consumptions()->where('report_type', 'express')->get();
        return response()->json([
            'success' => true,
            'data' => ['report' => $report, 'smartConsumptions' => $smartConsumptions, 'expressConsumptions' => $expressConsumptions]
        ]);
    }

    public function update(Request $request, Report $report)
    {
    }

    public function destroy(Report $report)
    {
    }

    public function getLastReport()
    {
        $item = DB::table('reports')->select('id', 'end_shift', 'smart_end_shift')->latest()->first();
        if (!$item)
            return response()->json([
                'success' => false,
                'data' => 'item not found'
            ]);
        return response()->json([
            'success' => true,
            'data' => $item
        ]);
    }
}
