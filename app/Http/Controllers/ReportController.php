<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon; // For handling dates

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Default to current month
        $start_date = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $end_date = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        // New Query: Group by Department AND Supply
        $report_data = Transaction::where('type', 'OUT')
            ->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
            ->selectRaw('department_id, supply_id, sum(quantity) as total_quantity')
            ->groupBy('department_id', 'supply_id')
            ->with(['supply', 'department'])
            ->orderBy('department_id') // Sort by Dept first so we can group them visually
            ->get();

        // Calculate a Grand Total of all items issued (optional but useful)
        $grand_total = $report_data->sum('total_quantity');

        return view('reports.consumption', compact('report_data', 'start_date', 'end_date', 'grand_total'));
    }
}