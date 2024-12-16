<?php

namespace App\Http\Controllers\Api;

use App\Filters\ReportFilter;
use App\Helpers\PaginateCollection;
use App\Http\Requests\StoreReportRequest;
use App\Http\Resources\ReportTableResource;
use App\Models\Branch;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $key = $request->key;
        $userRole = $request->user()->role;
        $cityId = $request->city_id;
        $branchId = $request->branch_id;

        $reports = Report::query();
        if ($userRole == 'user' || $userRole == 'branch_director') {
            $reports->where('branch_id', $request->user()->branch_id);
        }

        if ($userRole == 'region_director') {
            $branchIds = $request->user()->branches->pluck('id')->toArray();
            $reports->whereIn('branch_id', $branchIds);
        }

        $reports = $reports->select('id', 'user_id', 'branch_id', 'city_id', 'date', 'income_goods', 'smart_income_goods', 'own_capital', 'smart_own_capital', 'equity', 'smart_equity', 'interest_income', 'smart_interest_income', 'created_at', 'start_shift', 'smart_start_shift', 'end_shift', 'smart_end_shift', 'deposit_tickets', 'smart_deposit_tickets', DB::raw("(SELECT name FROM branches WHERE branch_id = branches.id) as branch_name"))
            ->orderBy('date', 'desc')
            ->withSum('consumptions', 'sum')
            ->when($key, function ($q) use ($key) {
                $q->where('own_capital', 'like', '%' . $key . '%')
                    ->orWhere('equity', 'like', '%' . $key . '%')
                    ->orWhere('income_goods', 'like', '%' . $key . '%');
            })
            ->when($cityId, function ($q) use ($cityId) {
                $q->where('city_id', $cityId);
            })
            ->when($branchId, function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            })
            ->get();

        $reports = (new ReportFilter())->handle($reports, $request->only('sum_start_shift', 'sum_end_shift', 'sum_own_capital', 'sum_equity', 'consumptions_sum_sum', 'net_profit', 'sum_income_goods', 'date_from', 'date_to'));
        //$paginatedData = (new PaginateCollection())->handle($reports, $request->page);\

        $total = [
            'net_profit' => 0,
            'consumptions_sum_sum' => 0,
            'sum_start_shift' => 0,
            'sum_end_shift' => 0,
            'sum_equity' => 0,
            'sum_own_capital' => 0,
            'sum_deposit_tickets' => 0
        ];
        $latestDate = null;
        if ($reports->count() > 0) {
            $latestDate = $reports->first()->date;
        }

        foreach ($reports as $report) {
            $total['net_profit'] += $report->net_profit;
            $total['consumptions_sum_sum'] += $report->consumptions_sum_sum;
            if ($report->date == $latestDate) {
                $total['sum_start_shift'] += $report->sum_start_shift;
                $total['sum_end_shift'] += $report->sum_end_shift;
                $total['sum_equity'] += $report->sum_equity;
                $total['sum_own_capital'] += $report->sum_own_capital;
                $total['sum_deposit_tickets'] += $report->sum_deposit_tickets;
            }
        }

        return response()->json(['data' => array_values($reports->toArray()), 'total' => $total], 200);
    }

    public function store(StoreReportRequest $request)
    {
        \DB::beginTransaction();
        $data = $request->all();
        $data['city_id'] = Branch::find($request->branch_id)->city_id;
        try {
            $report = Report::create($data);
            $report->consumptions()->createMany($request->smart_consumptions ?? []);
            $report->consumptions()->createMany($request->express_consumptions ?? []);
            \DB::commit();
            return response()->json([
                'success' => true,
                'data' => []
            ]);
        } catch (\Exception $e) {
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
            ->with('branch:id,name')
            ->find($report->id);
        $smartConsumptions = $report->consumptions()->where('report_type', 'smart')->get();
        $expressConsumptions = $report->consumptions()->where('report_type', 'express')->get();
        return response()->json([
            'success' => true,
            'data' => ['report' => $report, 'smartConsumptions' => $smartConsumptions, 'expressConsumptions' => $expressConsumptions]
        ]);
    }

    public function update(Request $request, int $reportId)
    {
        \DB::beginTransaction();
        $data = $request->all();
        $data['city_id'] = Branch::find($request->branch_id)->city_id;
        try {
            $report = Report::find($reportId);
            $report->update($data);
            $report->consumptions()->delete();
            $report->consumptions()->createMany($request->smart_consumptions ?? []);
            $report->consumptions()->createMany($request->express_consumptions ?? []);
            \DB::commit();
            return response()->json([
                'success' => true,
                'data' => []
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'data' => ['error' => $e->getMessage()]
            ]);
        }
        return response()->json($data);
    }

    public function destroy(int $reportId)
    {
        return Report::where('id', $reportId)->delete();
    }

    public function getLastReport(Request $request)
    {
        $branchId = $request->query('branch_id');
        $date = $request->query('date');
        $columnsToSelect = ['id', 'end_shift', 'smart_end_shift', 'fixed_flow', 'branch_id', 'smart_investor_capital', 'smart_borrowed_capital'];
        $selectQuery = DB::table('reports')->select($columnsToSelect);

        if ($branchId) {

            $now = !$date ? Carbon::now() : Carbon::parse($date);

            // Первый день текущего месяца
            $firstDayOfMonth = $now->copy()->startOfMonth();

            // Последний день текущего месяца
            $lastDayOfMonth = $now->copy()->endOfMonth();

            $item = $selectQuery
                ->where('date', '>=', $firstDayOfMonth)
                ->where('date', '<=', $lastDayOfMonth)
                ->where('branch_id', $branchId)
                ->orderBy('date', 'desc')
                ->first();
        } else {
            $item = $selectQuery
                ->orderBy('date', 'desc')
                ->first();
        }
        if (!$item)
            return response()->json([
                'success' => false,
                'data' => null
            ]);
        return response()->json([
            'success' => true,
            'data' => $item
        ]);
    }

    public function statistics(Request $request)
    {
        //return Report::whereDate('date', '2024-10-26')->get();

        $reports = DB::table('reports')
            ->leftJoin('consumptions', 'consumptions.report_id', '=', 'reports.id')
            ->selectRaw('
		        reports.date,
		        SUM(reports.fixed_flow) as total_fixed_flow,
		         COALESCE(SUM(consumptions.sum), 0) as total_consumptions,
        COALESCE(
            (SUM(reports.interest_income) + SUM(reports.income_goods) + SUM(reports.smart_interest_income) + SUM(reports.smart_income_goods) - COALESCE(SUM(consumptions.sum), 0)),
            0
        ) as net_profit
		    ')
            ->groupBy('reports.date')
            ->get();

        return response()->json($reports);

        //consumptions_sum_sum, net_profit, fixed_flow
        $cityId = $request->city_id;
        $branchId = $request->branch_id;
        $userRole = $request->user()->role;

        $reports = Report::query();
        if ($userRole == 'user' || $userRole == 'branch_director') {
            $reports->where('branch_id', $request->user()->branch_id);
        }

        if ($userRole == 'region_director') {
            $branchIds = $request->user()->branches->pluck('id')->toArray();
            $reports->whereIn('branch_id', $branchIds);
        }

        $reports = $reports->select('id', 'user_id', 'branch_id', 'city_id', 'date', 'income_goods', 'smart_income_goods', 'own_capital', 'smart_own_capital', 'equity', 'smart_equity', 'interest_income', 'smart_interest_income', 'created_at', 'start_shift', 'smart_start_shift', 'end_shift', 'smart_end_shift', 'deposit_tickets', 'smart_deposit_tickets', 'fixed_flow', 'smart_fixed_flow')
            ->groupBy('date')
            ->latest()
            ->withSum('consumptions', 'sum')
            #->selectRaw('DATE(created_at) as date, SUM(net_profit) as total_price')
            ->get();
        return response()->json($reports);
    }
}
