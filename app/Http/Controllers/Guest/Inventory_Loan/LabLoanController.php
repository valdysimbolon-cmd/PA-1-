<?php

namespace App\Http\Controllers\Guest\Inventory_Loan;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Lab;
use App\Models\LabLoan;
use App\Models\LabLoanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'nim'                  => 'required|numeric', // Harus Angka
            'lab_id'               => 'required|exists:labs,id',
            'planned_borrow_date'  => 'required|date|after_or_equal:today',
            'planned_return_date'  => 'required|date|after:planned_borrow_date',
            'research_title'       => 'required|string|max:255',
            'items'                => 'required|array|min:1',
            'items.*.inventory_id' => 'required|exists:inventory,id',
            'items.*.quantity'     => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $loan = LabLoan::create([
                'nim'                  => $request->nim, // Diambil dari input manual
                'borrower_name'        => $request->borrower_name, // Diambil dari input manual
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
                    throw new \Exception("Stok {$inv->item_name} tidak mencukupi.");
                }
                LabLoanDetail::create([
                    'lab_loan_id'  => $loan->id,
                    'inventory_id' => $item['inventory_id'],
                    'quantity'     => $item['quantity'],
                ]);
            }
            DB::commit();
            return redirect()->route('guest.loan.success', $loan->receipt_number);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function success($receipt_number)
    {
        $loan = LabLoan::with(['details.inventory', 'lab'])->where('receipt_number', $receipt_number)->firstOrFail();
        return view('guest.sukses', compact('loan'));
    }

    public function checkStatus(Request $request)
    {
        $student = session('pinjam_user');
        if (!$student) return redirect()->route('mybioproses.auth');

        $username = $student['username']; // If325021
        $numericPart = preg_replace('/[^0-9]/', '', $username); // ambil '325021'

        // Cari yang NIM-nya "If325021" ATAU mengandung angka "325021" (seperti 42325021)
        $loans = LabLoan::with(['details.inventory', 'lab'])
                    ->where('nim', $username) 
                    ->orWhere('nim', 'like', '%' . $numericPart) 
                    ->latest()
                    ->get();

        return view('guest.cek_status', compact('loans'));
    }

}