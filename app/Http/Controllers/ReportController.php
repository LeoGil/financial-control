<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(ReportService $reportService)
    {
        $report = $reportService->generateMonthlyReport(Auth::id());

        $series = $report['series'];
        $categories = $report['categories'];

        return view('reports.index', compact('series', 'categories'));
    }
}
