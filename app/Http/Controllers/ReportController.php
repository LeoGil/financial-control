<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(ReportService $reportService)
    {
        $report = [];
        $report['statementByMonth'] = $reportService->generateMonthlyReport(Auth::id());
        $report['statementByMonthByCategory'] = $reportService->generateMonthlyReportByCategory(Auth::id());

        return view('reports.index', compact('report'));
    }
}
