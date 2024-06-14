<?php

namespace App\Http\Controllers\Api;

use App\Filters\ReportFilter;
use App\Helpers\PaginateCollection;
use App\Http\Requests\StoreReportRequest;
use App\Http\Resources\ReportTableResource;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $key = $request->key;
        $reports = Report::query()
            ->select('id', 'income_goods', 'smart_income_goods', 'own_capital', 'smart_own_capital', 'equity', 'smart_equity', 'interest_income', 'smart_interest_income', 'created_at')
            ->latest()
            ->withSum('consumptions', 'sum')
            ->when($key, function ($q) use ($key){
                $q->where('own_capital', 'like', '%'.$key.'%')
                    ->orWhere('equity', 'like', '%'.$key.'%')
                    ->orWhere('income_goods', 'like', '%'.$key.'%');
            })
        ->get();

        $reports = (new ReportFilter())->handle($reports, $request->only('sum_own_capital', 'sum_equity', 'consumptions_sum_sum', 'net_profit', 'sum_income_goods', 'created_at'));

        $paginatedData = (new PaginateCollection())->handle($reports, $request->page);
        return response()->json($paginatedData);
        //return ReportTableResource::collection($reports);
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
        $item = Report::select('id', 'end_shift', 'smart_end_shift')->latest()->first();
        return response()->json([
            'success' => true,
            'data' => $item
        ]);
    }
}
