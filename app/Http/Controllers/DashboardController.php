<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\CustomersDataTable;
use App\DataTables\OrdersDataTable;
use App\DataTables\UsersDataTable;
use Illuminate\Support\Facades\DB;
use App\Charts\MonthlySalesChart;
use App\Charts\ItemChart;

class DashboardController extends Controller
{
    private $bgcolor = [
        '#C9A84C', '#e0c068', '#a07830', '#f0d888', '#806020',
        '#d4a840', '#b89028', '#c0a050', '#e8c878', '#987030',
        '#C9A84C', '#e0c068', '#a07830', '#f0d888', '#806020',
    ];

    public function index(Request $request)
    {
        // ── Stat Cards ────────────────────────────────────────────────────────
        $totalOrders  = DB::table('orders')->count();
        $totalRevenue = DB::table('order_items')->sum('subtotal');
        $totalUsers   = DB::table('users')->count();
        $totalItems   = DB::table('item')->whereNull('deleted_at')->count();

        // ── 1. Yearly Sales Bar Chart (last 5 years) ──────────────────────────
        $yearlySalesRaw = DB::table('orders as o')
            ->join('order_items as oi', 'o.order_id', '=', 'oi.order_id')
            ->whereBetween(DB::raw('YEAR(o.order_date)'), [now()->year - 4, now()->year])
            ->groupBy(DB::raw('YEAR(o.order_date)'))
            ->orderBy(DB::raw('YEAR(o.order_date)'))
            ->pluck(DB::raw('SUM(oi.subtotal) as total'), DB::raw('YEAR(o.order_date) as year'))
            ->all();

        $yearLabels = [];
        $yearTotals = [];
        for ($y = now()->year - 4; $y <= now()->year; $y++) {
            $yearLabels[] = (string) $y;
            $yearTotals[] = round($yearlySalesRaw[$y] ?? 0, 2);
        }

        $yearlyChart = new MonthlySalesChart;
        $yearlyChart->labels($yearLabels);
        $dataset = $yearlyChart->dataset('Yearly Revenue (₱)', 'bar', $yearTotals);
        $dataset->backgroundColor($this->bgcolor);
        $yearlyChart->options([
            'responsive'  => true,
            'aspectRatio' => 6,
            'legend'      => ['display' => false],
            'tooltips'    => ['enabled' => true],
            'scales'      => [
                'yAxes' => [['display' => true, 'ticks' => ['beginAtZero' => true, 'maxTicksLimit' => 5]]],
                'xAxes' => [['gridLines' => ['display' => false], 'display' => true]],
            ],
        ]);

        // ── 2. Sales by Product Bar Chart with Date Range ─────────────────────
        $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo   = $request->input('date_to',   now()->format('Y-m-d'));

        $productSalesRaw = DB::table('orders as o')
            ->join('order_items as oi', 'o.order_id', '=', 'oi.order_id')
            ->join('item as i', 'oi.item_id', '=', 'i.item_id')
            ->whereBetween(DB::raw('DATE(o.order_date)'), [$dateFrom, $dateTo])
            ->select('i.title', DB::raw('SUM(oi.subtotal) as total'))
            ->groupBy('i.item_id', 'i.title')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $productBarChart = new MonthlySalesChart;
        $productBarChart->labels($productSalesRaw->pluck('title')->toArray());
        $dataset = $productBarChart->dataset('Revenue (₱)', 'bar', $productSalesRaw->map(fn($r) => round($r->total, 2))->toArray());
        $dataset->backgroundColor($this->bgcolor);
        $productBarChart->options([
            'responsive'  => true,
            'aspectRatio' => 4,
            'legend'      => ['display' => false],
            'tooltips'    => ['enabled' => true],
            'scales'      => [
                'yAxes' => [['display' => true, 'ticks' => ['beginAtZero' => true, 'maxTicksLimit' => 5]]],
                'xAxes' => [['gridLines' => ['display' => false], 'display' => true]],
            ],
        ]);

        // ── 3. Sales per Product Pie Chart ────────────────────────────────────
        $itemsRaw = DB::table('order_items AS oi')
            ->join('item AS i', 'oi.item_id', '=', 'i.item_id')
            ->join('orders AS o', 'oi.order_id', '=', 'o.order_id')
            ->groupBy('i.item_id', 'i.title')
            ->orderByDesc('total')
            ->select('i.title', DB::raw('SUM(oi.subtotal) AS total'))
            ->get();

        $grandTotal = $itemsRaw->sum('total') ?: 1;
        $pieData = $itemsRaw->map(fn($r) => round(($r->total / $grandTotal) * 100, 2))->toArray();

        $itemChart = new ItemChart;
        $itemChart->labels($itemsRaw->pluck('title')->toArray());
        $dataset = $itemChart->dataset('% of Sales', 'pie', $pieData);
        $dataset->backgroundColor($this->bgcolor);
        $dataset->fill(false);
        $itemChart->options([
            'responsive'  => true,
            'aspectRatio' => 1.3,
            'legend'      => ['display' => false],
            'tooltips'    => ['enabled' => true],
            'scales'      => [
                'x'     => ['display' => false],
                'y'     => ['display' => false],
                'xAxes' => [['display' => false]],
                'yAxes' => [['display' => false]],
            ],
        ]);

        return view('dashboard.index', compact(
            'yearlyChart',
            'productBarChart',
            'itemChart',
            'dateFrom',
            'dateTo',
            'totalOrders',
            'totalRevenue',
            'totalUsers',
            'totalItems'
        ));
    }

    public function productChartData(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo   = $request->input('date_to',   now()->format('Y-m-d'));

        $data = DB::table('orders as o')
            ->join('order_items as oi', 'o.order_id', '=', 'oi.order_id')
            ->join('item as i', 'oi.item_id', '=', 'i.item_id')
            ->whereBetween(DB::raw('DATE(o.order_date)'), [$dateFrom, $dateTo])
            ->select('i.title', DB::raw('SUM(oi.subtotal) as total'))
            ->groupBy('i.item_id', 'i.title')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return response()->json([
            'labels' => $data->pluck('title'),
            'totals' => $data->map(fn($r) => round($r->total, 2)),
        ]);
    }

    public function getUsers(UsersDataTable $dataTable, Request $request)
    {
        if ($request->ajax()) return $dataTable->ajax();
        return $dataTable->render('dashboard.users');
    }

    public function getCustomers(CustomersDataTable $dataTable)
    {
        return $dataTable->render('dashboard.orders');
    }

    public function getOrders(OrdersDataTable $dataTable, Request $request)
    {
        if ($request->ajax()) return $dataTable->ajax();
        return $dataTable->render('dashboard.orders');
    }
}