<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Payment;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.report.index');
    }

    public function generateReport($type)
    {
        switch ($type) {
            case 'today':
                $payments = Payment::where('status', 'paid')->whereDate('created_at', Carbon::today())->get();
                $filename = 'today_report.pdf';
                break;
            case 'weekly':
                $payments = Payment::where('status', 'paid')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
                $filename = 'weekly_report.pdf';
                break;
            case 'monthly':
                $payments = Payment::where('status', 'paid')->whereMonth('created_at', Carbon::now()->month)->get();
                $filename = 'monthly_report.pdf';
                break;
            case 'semi-annual':
                $start = Carbon::now()->subMonths(6);
                $end = Carbon::now();
                $payments = Payment::where('status', 'paid')->whereBetween('created_at', [$start, $end])->get();
                $filename = 'semi_annual_report.pdf';
                break;
            case 'annual':
                $payments = Payment::where('status', 'paid')->whereYear('created_at', Carbon::now()->year)->get();
                $filename = 'annual_report.pdf';
                break;
            default:
                return response()->json(['error' => 'Invalid report type'], 400);
        }

        return $this->generatePDF($payments, $filename);
    }

    public function getReportData($type)
    {
        switch ($type) {
            case 'today':
                $payments = Payment::where('status', 'paid')->whereDate('created_at', Carbon::today())->get();
                $reservations = Reservation::where('status', 'confirmed')->whereDate('created_at', Carbon::today())->count();
                $clients = User::where('role_id', 0)->whereDate('created_at', Carbon::today())->count();
                break;
            case 'weekly':
                $payments = Payment::where('status', 'paid')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
                $reservations = Reservation::where('status', 'confirmed')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                $clients = User::where('role_id', 0)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                break;
            case 'monthly':
                $payments = Payment::where('status', 'paid')->whereMonth('created_at', Carbon::now()->month)->get();
                $reservations = Reservation::where('status', 'confirmed')->whereMonth('created_at', Carbon::now()->month)->count();
                $clients = User::where('role_id', 0)->whereMonth('created_at', Carbon::now()->month)->count();
                break;
            case 'semi-annual':
                $start = Carbon::now()->subMonths(6);
                $end = Carbon::now();
                $payments = Payment::where('status', 'paid')->whereBetween('created_at', [$start, $end])->get();
                $reservations = Reservation::where('status', 'confirmed')->whereBetween('created_at', [$start, $end])->count();
                $clients = User::where('role_id', 0)->whereBetween('created_at', [$start, $end])->count();
                break;
            case 'annual':
                $payments = Payment::where('status', 'paid')->whereYear('created_at', Carbon::now()->year)->get();
                $reservations = Reservation::where('status', 'confirmed')->whereYear('created_at', Carbon::now()->year)->count();
                $clients = User::where('role_id', 0)->whereYear('created_at', Carbon::now()->year)->count();
                break;
            default:
                return response()->json(['error' => 'Invalid report type'], 400);
        }

        $totalRevenue = $payments->sum('total');

        return response()->json([
            'payments' => $payments,
            'stats' => [
                'totalRevenue' => $totalRevenue,
                'reservations' => $reservations,
                'clients' => $clients
            ]
        ]);
    }

    private function generatePDF($payments, $filename)
    {
        $pdf = PDF::loadView('report.payments', compact('payments'));
        return $pdf->download($filename);
    }
}
