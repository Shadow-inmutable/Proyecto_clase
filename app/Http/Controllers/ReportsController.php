<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Movement;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->query('period', 'day');
        $from = $request->query('from');
        $to = $request->query('to');

        [$start, $end] = $this->buildRange($period, $from, $to);

        // Totales generales
        $totalProducts = Product::count();

        // Movimientos en rango: unidades y valor (unidades * product price)
        $totalUnits = Movement::whereBetween('created_at', [$start, $end])->sum('ammount');

        $totalValue = Movement::select(DB::raw('SUM(movements.ammount * products.price) as total_value'))
            ->join('products', 'products.id', '=', 'movements.product_id')
            ->whereBetween('movements.created_at', [$start, $end])
            ->value('total_value') ?: 0;

        // Build grouped series depending on span length
        $diffDays = $start->diffInDays($end);
        if ($diffDays > 365) {
            // group by year
            $groupFormat = "%Y";
            $labelFormat = 'Y';
            $periodStep = 'year';
        } elseif ($diffDays > 90) {
            // group by month
            $groupFormat = "%Y-%m";
            $labelFormat = 'Y-m';
            $periodStep = 'month';
        } elseif ($diffDays > 14) {
            // group by week
            $groupFormat = "%Y-%u"; // year-week
            $labelFormat = 'Y-[W]W';
            $periodStep = 'week';
        } else {
            // group by day
            $groupFormat = "%Y-%m-%d";
            $labelFormat = 'Y-m-d';
            $periodStep = 'day';
        }

        // Query grouped data: units and value
        $rows = Movement::select(DB::raw("DATE_FORMAT(movements.created_at, '$groupFormat') as period"),
            DB::raw('SUM(movements.ammount) as units'),
            DB::raw('SUM(movements.ammount * products.price) as value'))
            ->leftJoin('products', 'products.id', '=', 'movements.product_id')
            ->whereBetween('movements.created_at', [$start, $end])
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->keyBy('period');

        // Build labels and fill zeros for continuity
        $labels = [];
        $dataUnits = [];
        $dataValue = [];

        $cursor = $start->copy();
        while ($cursor->lte($end)) {
            if ($periodStep === 'day') {
                $key = $cursor->format('Y-m-d');
                $labels[] = $key;
                $row = $rows->get($key);
                $dataUnits[] = $row ? (int)$row->units : 0;
                $dataValue[] = $row ? (float)$row->value : 0;
                $cursor->addDay();
            } elseif ($periodStep === 'week') {
                $key = $cursor->format('o-') . $cursor->format('W'); // ISO year-week
                $labels[] = $key;
                $row = $rows->get(strftime('%Y-%V', $cursor->timestamp));
                $dataUnits[] = $row ? (int)$row->units : 0;
                $dataValue[] = $row ? (float)$row->value : 0;
                $cursor->addWeek();
            } elseif ($periodStep === 'month') {
                $key = $cursor->format('Y-m');
                $labels[] = $key;
                $row = $rows->get($key);
                $dataUnits[] = $row ? (int)$row->units : 0;
                $dataValue[] = $row ? (float)$row->value : 0;
                $cursor->addMonth();
            } else {
                // year
                $key = $cursor->format('Y');
                $labels[] = $key;
                $row = $rows->get($key);
                $dataUnits[] = $row ? (int)$row->units : 0;
                $dataValue[] = $row ? (float)$row->value : 0;
                $cursor->addYear();
            }
        }

        return view('reports.index', compact('period','start','end','totalProducts','totalUnits','totalValue','labels','dataUnits','dataValue'));
    }

    protected function buildRange($period, $from = null, $to = null)
    {
        $today = Carbon::today();
        switch ($period) {
            case 'week':
                return [$today->startOfWeek(), $today->endOfWeek()];
            case 'month':
                return [$today->startOfMonth(), $today->endOfMonth()];
            case 'year':
                return [$today->startOfYear(), $today->endOfYear()];
            case 'range':
                $start = $from ? Carbon::parse($from)->startOfDay() : $today->startOfMonth();
                $end = $to ? Carbon::parse($to)->endOfDay() : $today->endOfDay();
                return [$start, $end];
            case 'day':
            default:
                return [$today->startOfDay(), $today->endOfDay()];
        }
    }

    public function exportPdf(Request $request)
    {
        // reuse index logic to build data
        $period = $request->query('period', 'day');
        $from = $request->query('from');
        $to = $request->query('to');
        [$start, $end] = $this->buildRange($period, $from, $to);

        $totalProducts = Product::count();
        $totalUnits = Movement::whereBetween('created_at', [$start, $end])->sum('ammount');
        $totalValue = Movement::select(DB::raw('SUM(movements.ammount * products.price) as total_value'))
            ->join('products', 'products.id', '=', 'movements.product_id')
            ->whereBetween('movements.created_at', [$start, $end])
            ->value('total_value') ?: 0;

        // group by day for PDF summary (simpler)
        $rows = Movement::select(DB::raw("DATE(movements.created_at) as period"), DB::raw('SUM(movements.ammount) as units'), DB::raw('SUM(movements.ammount * products.price) as value'))
            ->leftJoin('products', 'products.id', '=', 'movements.product_id')
            ->whereBetween('movements.created_at', [$start, $end])
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('reports.pdf', compact('period','start','end','totalProducts','totalUnits','totalValue','rows'));
        return $pdf->stream('report_' . $start->format('Ymd') . '_' . $end->format('Ymd') . '.pdf');
    }
}
