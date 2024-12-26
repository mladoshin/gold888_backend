<?php

namespace App\Http\Controllers\Api;

use App\Filters\ReportFilter;
use App\Helpers\PaginateCollection;
use App\Http\Requests\StoreReportRequest;
use App\Http\Resources\CityReportsResource;
use App\Http\Resources\ReportTableResource;
use App\Models\Branch;
use App\Models\Report;
use App\Service\ReportService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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

        $reports = $reports->select('id', 'user_id', 'branch_id',  'date', 'income_goods', 'smart_income_goods', 'own_capital', 'smart_own_capital', 'equity', 'smart_equity', 'interest_income', 'smart_interest_income', 'created_at', 'start_shift', 'smart_start_shift', 'end_shift', 'smart_end_shift', 'deposit_tickets', 'smart_deposit_tickets', DB::raw("(SELECT name FROM branches WHERE branch_id = branches.id) as branch_name"))
            ->orderBy('date', 'desc')
            ->withSum('consumptions', 'sum')
            ->when($key, function ($q) use ($key) {
                $q->where('own_capital', 'like', '%' . $key . '%')
                    ->orWhere('equity', 'like', '%' . $key . '%')
                    ->orWhere('income_goods', 'like', '%' . $key . '%');
            })
            ->when($cityId, function ($q) use ($cityId) {
                $branchIds = Branch::where('city_id', $cityId)->pluck('id');
                $q->whereIn('branch_id', $branchIds);
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
        $data = array_merge(
            array_fill_keys(array_keys($request->rules()), null),
            $request->validated()
        );
        $data['user_id'] = Auth::id();
        try {
            $report = Report::create($data);
            if(isset($request->smart_consumptions))  $report->consumptions()->createMany($request->smart_consumptions ?? []);
            if(isset($request->express_consumptions)) $report->consumptions()->createMany($request->express_consumptions ?? []);
            return response()->json([
                'success' => true,
                'data' => $report
            ]);
        } catch (\Exception $e) {
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

    public function update(StoreReportRequest $request, int $reportId)
    {
        $data = array_merge(
            array_fill_keys(array_keys($request->rules()), null),
            $request->validated()
        );
        $data['user_id'] = Auth::id();
        try {
            $report = Report::find($reportId);
            $report->update($data);
            $report->consumptions()->delete();
            $report->consumptions()->createMany($request->smart_consumptions ?? []);
            $report->consumptions()->createMany($request->express_consumptions ?? []);
            return response()->json([
                'success' => true,
                'data' => $report
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'data' => ['error' => $e->getMessage()]
            ]);
        }

    }

    public function destroy(int $reportId)
    {
        $report = Report::find($reportId);
        $report->consumptions()->delete();
        return $report->delete();
    }

    public function incomeCity()
    {
        $reports =Report::get();
        if(count($reports)==0)  return response()->json([
            'success' => false,
            'data' => null
        ]);
        $res = [];
        foreach ($reports as $report) {
            $cityId = $report->city->id;
            if (isset($res[$cityId])) {
                $res[$cityId]['income'] += $report->calculateIncome();
                $res[$cityId]['expenses'] += $report->calculateExpenses();
                $res[$cityId]['total'] += $report->getNetProfitAttribute();
            } else {
                $res[$cityId] = [
                    'city_id' => $cityId,
                    'city_name' => $report->city->name,
                    'income' => $report->calculateIncome(),
                    'expenses' => $report->calculateExpenses(),
                    'total' => $report->getNetProfitAttribute(),
                ];
            }
        }
        return response()->json([
            'success' => true,
            'data' => $res
        ]);
    }

    public function analyticsDate(Request $request)
    {
        try {
            $service = ReportService::validation($request);
            $periodFormat =$service['periodFormat'];
            $query =$service['query'];
            $reports =$query->get();
            if (count($reports)==0) return response()->json([
                'success' => 'ok',
                'data' => []
            ]);
            $currentDate =  Carbon::make($reports[0]->created_at)->format($periodFormat);
            $tmpRes = ['income'=> 0, 'expenses'=> 0, 'total' => 0, 'selling_goods' => 0, 'fixed_flow'=>0 ];
            $res = [];

            foreach ($reports as $report) {
                if($currentDate == Carbon::make($report->created_at)->format($periodFormat)){
                    $tmpRes['income'] += $report->calculateIncome();
                    $tmpRes['expenses'] += $report->calculateExpenses();
                    $tmpRes['total'] += $report->getNetProfitAttribute();
                    $tmpRes['selling_goods'] +=  $report->selling_goods ?? 0;
                    $tmpRes['fixed_flow'] +=  $report->fixed_flow ?? 0;
                } else {
                    $res[$currentDate] = $tmpRes;
                    $currentDate = Carbon::make($report->created_at)->format($periodFormat);
                    $tmpRes = [
                        'income'=> $report->calculateIncome(),
                        'expenses'=> $report->calculateExpenses(),
                        'total' => $report->getNetProfitAttribute(),
                        'selling_goods' => $report->selling_goods ?? 0,
                        'fixed_flow' => $report->fixed_flow ?? 0
                    ];
                }
            }
            if(count($res)!==count($tmpRes)) $res = $tmpRes;
            return response()->json([
                'success' => 'ok',
                'data' => $res
            ]);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
    public function amountUsedCollateralGoods(Request $request)
    {
        try {
            $query = ReportService::validation($request)['query'];
            $reports =$query->get();
            $res = [
                'used_goods' =>0,
                'deposit_tickets'=>0,
                'selling_goods'=>0

            ];
            foreach ($reports as $report) {
                $res['used_goods'] += $report->used_goods ?? 0;
                $res['deposit_tickets'] += $report->deposit_tickets ?? 0;
                $res['selling_goods'] += $report->selling_goods ?? 0;
            }
            return response()->json([
                'success' => 'ok',
                'data' => $res
            ]);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function getLastReport(Request $request)
    {
        $branchId = $request->query('branch_id');
        $date = $request->query('date');
        $columnsToSelect = ['id', 'end_shift', 'smart_end_shift', 'fixed_flow', 'branch_id', 'smart_investor_capital', 'smart_borrowed_capital'];
        $selectQuery = DB::table('reports')->select($columnsToSelect);

        if ($branchId) {

            $now = !$date ? Carbon::now() : Carbon::parse($date);
            $firstDayOfMonth = $now->copy()->startOfMonth();
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
