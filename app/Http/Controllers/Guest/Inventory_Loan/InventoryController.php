<?php

namespace App\Http\Controllers\Guest\Inventory_Loan;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Katalog Alat untuk Mahasiswa
     */
    public function index(Request $request)
    {
        $query = Inventory::where('active', true);
        $items = $query->orderBy('item_name')->get();
        
        // Ambil data lab agar dropdown di form terisi
        $labs = \App\Models\Lab::where('active', true)->get();

        // HAPUS 'laboratorium', langsung ke 'guest.peminjaman'
        return view('guest.peminjaman', compact('items', 'labs')); 
    }
}