<?php

namespace App\Http\Controllers\Admin\inventory_Loan;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\LabLoan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LoanReportExport;
use App\Exports\InventoryReportExport;

/**
 * Class ReportController
 *
 * Mengelola laporan untuk data peminjaman dan inventaris.
 * Bisa diakses oleh Super Admin dan Admin Lab (untuk mendukung operasional).
 */
class ReportController extends Controller
{
    private function authorizeRole(array $roles): void
    {
        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'Akses ditolak.');
        }
    }

    public function index()
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);
        return view('admin.report.index');
    }

    public function previewLoan(Request $request)
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);
        $loans = $this->getLoanQuery($request)->get();
        return view('admin.report.preview-loan', compact('loans', 'request'));
    }

    public function exportLoanPdf(Request $request)
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);
        $loans  = $this->getLoanQuery($request)->get();
        $title  = 'Laporan Peminjaman Alat & Bahan Lab';
        $period = $this->getPeriodLabel($request);

        $pdf = Pdf::loadView('admin.report.pdf.loan', compact('loans', 'title', 'period'))
            ->setPaper('a4', 'landscape');

        $filename = 'laporan-peminjaman-' . now()->format('Ymd-His') . '.pdf';
        return $pdf->download($filename);
    }

    public function exportLoanExcel(Request $request)
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);
        $filename = 'laporan-peminjaman-' . now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new LoanReportExport($request->all()), $filename);
    }

    public function previewInventory(Request $request)
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);
        $inventories = Inventory::query()
            ->when($request->active !== null, fn($q) => $q->where('active', $request->active))
            ->orderBy('item_name')
            ->get();
        return view('admin.report.preview-inventory', compact('inventories'));
    }

    public function exportInventoryPdf(Request $request)
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);
        $inventories = Inventory::orderBy('item_name')->get();
        $title       = 'Laporan Data Inventaris Lab';

        $pdf = Pdf::loadView('admin.report.pdf.inventory', compact('inventories', 'title'))
            ->setPaper('a4', 'landscape');

        $filename = 'laporan-inventaris-' . now()->format('Ymd-His') . '.pdf';
        return $pdf->download($filename);
    }

    public function exportInventoryExcel()
    {
        $this->authorizeRole(['super_admin', 'admin_lab']);
        $filename = 'laporan-inventaris-' . now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new InventoryReportExport(), $filename);
    }

    private function getLoanQuery(Request $request)
    {
        return LabLoan::with(['details.inventory', 'lab'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->date_from, fn($q) => $q->whereDate('created_at', '>=', $request->date_from))
            ->when($request->date_to,   fn($q) => $q->whereDate('created_at', '<=', $request->date_to))
            ->when($request->nim,       fn($q) => $q->where('nim', 'like', "%{$request->nim}%"))
            ->latest();
    }

    private function getPeriodLabel(Request $request): string
    {
        if ($request->date_from && $request->date_to) {
            return $request->date_from . ' s/d ' . $request->date_to;
        }
        return 'Semua periode';
    }
}