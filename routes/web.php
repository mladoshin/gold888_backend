<?php

use App\Models\Overdue;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/clear', function () {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Log::debug('CLEARED');
    Artisan::call('route:clear');
    return "Cache clear";
});

Route::get('/', function () {
//    $reports =Report::get();
//    $currentDate = '';
//    $tmpRes = [];
//    $res = [];
//    foreach ($reports as $report) {
//        if($currentDate == Carbon::make($report->created_at)->format('d-m-Y')){
//            $tmpRes['income'] += $report->calculateIncome();
//            $tmpRes['expenses'] += $report->calculateExpenses();
//            $tmpRes['total'] += $report->getNetProfitAttribute();
//        } else {
//            if  ($currentDate != '') $res[$currentDate] = $tmpRes;
//            $currentDate = Carbon::make($report->created_at)->format('d-m-Y');
//            $tmpRes = [
//                'income'=> $report->calculateIncome(),
//                'expenses'=> $report->calculateExpenses(),
//                'total' => $report->getNetProfitAttribute()
//            ];
//        }
//    }
//    dd($res);

    \Artisan::call('optimize');
    \Artisan::call('route:clear');
    \Artisan::call('migrate');
    return view('welcome');
});
