<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::latest()->paginate(10);
        return response()->json([
            'success' => true,
            'data' => $reports
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
