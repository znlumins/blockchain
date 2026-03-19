<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class BlockchainController extends Controller
{
    public function index()
    {
        // Mengambil semua log aktivitas dari semua proyek & user (Global Ledger)
        $logs = AuditLog::orderBy('id', 'desc')->paginate(15);
        
        return view('admin.blockchain.index', compact('logs'));
    }
}