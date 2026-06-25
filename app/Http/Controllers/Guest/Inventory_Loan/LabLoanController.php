<?php

namespace App\Http\Controllers\Guest\Inventory_Loan;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Lab;
use App\Models\LabLoan;
use App\Models\LabLoanDetail;
use App\Models\User; // Tambahkan ini
use App\Notifications\PeminjamanBaru; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification; // Tambahkan ini
use Illuminate\Support\Str;

class LabLoanController extends Controller
{
    public function create()
    {
        $student = session('pinjam_user'); 
        $items = Inventory::where('active', true)->where('quantity_available', '>', 0)->orderBy('item_name')->get();
        $labs = Lab::where('active', true)->get();
        
        return view('guest.peminjaman', compact('student', 'items', 'labs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'borrower_name'        => 'required|string|max:255',
            'nim'                  => 'required|numeric', 
            'lab_id'               => 'required|exists:labs,id',
            'planned_borrow_date'  => 'required|date|after_or_equal:today',
            'planned_return_date'  => 'required|date|after_or_equal:planned_borrow_date',
            'research_title'       => 'required|string|max:255',
            'items'                => 'required|array|min:1',
            'items.*.inventory_id' => 'required|exists:inventory,id',
            'items.*.quantity'     => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $loan = LabLoan::create([
                'nim'                  => $request->nim, 
                'borrower_name'        => $request->borrower_name,
                'study_program'        => 'Bioprocess', 
                'research_title'       => $request->research_title,
                'planned_borrow_date'  => $request->planned_borrow_date,
                'planned_return_date'  => $request->planned_return_date,
                'lab_id'               => $request->lab_id,
                'receipt_number'       => 'REQ-' . strtoupper(Str::random(8)),
                'status'               => 'pending',
            ]);

            foreach ($request->items as $item) {
                if (!isset($item['inventory_id'])) continue;
                $inv = Inventory::findOrFail($item['inventory_id']);
                if ($inv->quantity_available < $item['quantity']) {
                    throw new \Exception("Stok alat '{$inv->item_name}' tidak mencukupi.");
                }
                LabLoanDetail::create([
                    'lab_loan_id'  => $loan->id,
                    'inventory_id' => $item['inventory_id'],
                    'quantity'     => $item['quantity'],
                ]);
            }

            DB::commit();

            // --- KIRIM NOTIFIKASI KE ADMIN ---
            $admins = User::whereIn('role', ['super_admin', 'admin_lab'])->get();
            Notification::send($admins, new PeminjamanBaru($loan));
            // ---------------------------------

            return redirect()->route('guest.loan.success', $loan->receipt_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    // METHOD INI YANG TADI HILANG / TIDAK DITEMUKAN
    public function success($receipt)
    {
        $loan = LabLoan::with(['details.inventory', 'lab'])
                    ->where('receipt_number', $receipt)
                    ->firstOrFail();

        return view('guest.sukses', compact('loan'));
    }

    public function checkStatus(Request $request)
    {
        $student = session('pinjam_user');
        if (!$student) return redirect()->route('mybioproses.auth');

        $username = $student['username']; 
        $numericPart = preg_replace('/[^0-9]/', '', $username); 

        $query = LabLoan::with(['details.inventory', 'lab'])
                    ->where(function($q) use ($username, $numericPart) {
                        $q->where('nim', $username)
                          ->orWhere('nim', 'like', '%' . $numericPart);
                    });

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('receipt_number', 'like', "%{$request->search}%")
                  ->orWhere('research_title', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('planned_borrow_date', $request->date);
        }

        $loans = $query->latest()->paginate(10);

        return view('guest.cek_status', compact('loans'));
    }
}