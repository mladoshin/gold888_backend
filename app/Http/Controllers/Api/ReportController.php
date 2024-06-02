<?php

namespace App\Http\Controllers\Api;

use App\Filters\ReportFilter;
use App\Helpers\PaginateCollection;
use App\Http\Requests\StoreReportRequest;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class ReportController extends Controller
{
    public function index(Request $request)
    {
        $key = $request->key;
        $reports = Report::query()
            ->latest()
            ->withSum('consumptions', 'sum')
            ->when($key, function ($q) use ($key){
                $q->where('own_capital', 'like', '%'.$key.'%')
                    ->orWhere('equity', 'like', '%'.$key.'%')
                    ->orWhere('income_goods', 'like', '%'.$key.'%');
            })
            ->get();


        $reports = (new ReportFilter())->handle($reports, $request->only('own_capital', 'equity', 'consumptions_sum_sum', 'netProfit', 'income_goods', 'created_at'));

        $paginatedData = (new PaginateCollection())->handle($reports, $request->page);

        return response()->json([
            'success' => true,
            'data' => $paginatedData
        ]);
    }

    public function test(Request $request)
    {
        $key = $request->key;
        $reports = Report::query()
            ->latest()
            ->withSum('consumptions', 'sum')
            ->when($key, function ($q) use ($key){
                $q->where('own_capital', 'like', '%'.$key.'%')
                    ->orWhere('equity', 'like', '%'.$key.'%')
                    ->orWhere('income_goods', 'like', '%'.$key.'%');
            })
            ->get();


        $reports = (new ReportFilter())->handle($reports, $request->only('own_capital', 'equity', 'consumptions_sum_sum', 'netProfit', 'income_goods', 'created_at'));

        $paginatedData = (new PaginateCollection())->handle($reports, $request->page);

        return response()->json([
            'success' => true,
            'data' => $paginatedData
        ]);
    }

    public function store(StoreReportRequest $request)
    {
        \DB::beginTransaction();
        try {
            $report = Report::create($request->validated());
            $report->consumptions()->createMany($request->consumptions);
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
        $report->load('consumptions');
        return response()->json([
            'success' => true,
            'data' => $report
        ]);
    }

    public function update(Request $request, Report $report)
    {
    }

    public function destroy(Report $report)
    {
    }
}
