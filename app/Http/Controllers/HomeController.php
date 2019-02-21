<?php

namespace App\Http\Controllers;

use App\Charts\SampleChart;
use App\Invoice;
use App\User;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this_month = Invoice::whereBetween('invoices.created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('total_price');
        $last_month = Invoice::whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])->sum('total_price');
        $last_2_months = Invoice::whereBetween('created_at', [Carbon::now()->subMonths(2)->startOfMonth(), Carbon::now()->subMonths(2)->endOfMonth()])->sum('total_price');

        $chart = new SampleChart;
        $chart->labels(['2 months ago', 'Last month', 'This month']);
        $chart->dataset('Price', 'line', [(int)$last_2_months, (int)$last_month, (int)$this_month])->color('red');

        $count_this_month = Invoice::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
        $count_last_month = Invoice::whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])->count();
        $count_last_2_months = Invoice::whereBetween('created_at', [Carbon::now()->subMonths(2)->startOfMonth(), Carbon::now()->subMonths(2)->endOfMonth()])->count();

        $chart2 = new SampleChart;
        $chart2->labels(['2 months ago', 'Last month', 'This month']);
        $chart2->dataset('Count', 'bar', [$count_last_2_months, $count_last_month, $count_this_month])->color('blue');

        $brandperf_this_month = Invoice::whereBetween('invoices.created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->join('invoice_details', 'invoices.id', '=', 'invoice_details.invoice_id')
            ->groupBy('brand')
            ->selectRaw('sum(total_price) as total, brand')->get();

        $brandperf_last_month = Invoice::whereBetween('invoices.created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])
            ->join('invoice_details', 'invoices.id', '=', 'invoice_details.invoice_id')
            ->groupBy('brand')
            ->selectRaw('sum(total_price) as total, brand')->get();

        $brandperf_last_2_months = Invoice::whereBetween('invoices.created_at', [Carbon::now()->subMonths(2)->startOfMonth(), Carbon::now()->subMonths(2)->endOfMonth()])
            ->join('invoice_details', 'invoices.id', '=', 'invoice_details.invoice_id')
            ->groupBy('brand')
            ->selectRaw('sum(total_price) as total, brand')->get();

        $chart3 = new SampleChart;
        $chart3->labels($brandperf_this_month->map(function ($data) {
            return $data->brand;
        })->toArray());
        $chart3->dataset('Revenue this month', 'line', $brandperf_this_month->map(function ($data) {
            return (int) $data->total;
        })->toArray())->color('red');
        $chart3->dataset('Revenue last '. Carbon::now()->subMonth()->format('F'), 'line', $brandperf_last_month->map(function ($data) {
            return (int) $data->total;
        })->toArray())->color('blue');
        $chart3->dataset('Revenue last '. Carbon::now()->subMonths(2)->format('F') , 'line', $brandperf_last_2_months->map(function ($data) {
            return (int) $data->total;
        })->toArray())->color('grey');
        return view('home', compact('chart', 'chart2', 'chart3', 'this_month', 'last_month', 'last_2_months'));


    }
}
