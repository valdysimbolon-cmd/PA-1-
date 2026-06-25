<?php

namespace App\Http\Controllers\Guest\Inventory_Loan;

use App\Http\Controllers\Controller;
use App\Models\LabLoan;
use Illuminate\Http\Request;

class LoanActionController extends Controller
{
    /**
     * Menampilkan riwayat peminjaman mahasiswa yang sedang login
     */
    public function index()
    {
        $student = session('pinjam_user');
        $nim = $student['username'] ?? $student['nim'];

        $myLoans = LabLoan::with(['details.inventory', 'lab'])
                    ->where('nim', $nim)
                    ->latest()
                    ->paginate(10);

        return view('guest.loan.history', compact('myLoans'));
    }

    /**
     * Fitur lacak peminjaman berdasarkan nomor resi (Public/Guest)
     */
    public function track(Request $request)
    {
        $loan = null;
        if ($request->filled('receipt_number')) {
            $loan = LabLoan::with(['details.inventory', 'lab'])
                    ->where('receipt_number', $request->receipt_number)
                    ->first();

            if (!$loan) {
                return back()->with('error', 'Nomor resi tidak ditemukan.');
            }
        }

        return view('guest.loan.track', compact('loan'));
    }
}