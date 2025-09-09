<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogTester;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $logs = LogTester::orderBy('tanggal_uji', 'desc')->get();
        
        return view('admin.dashboard', compact('logs'));
    }
    
    public function logs()
    {
        $logs = LogTester::orderBy('tanggal_uji', 'desc')->paginate(20);
        
        return view('admin.logs', compact('logs'));
    }
    
    public function components()
    {
        $components = LogTester::select('komponen_terdeteksi')
                                ->distinct()
                                ->orderBy('komponen_terdeteksi')
                                ->get();
        
        return view('admin.components', compact('components'));
    }
    
    public function reports()
    {
        $logs = LogTester::all();
        $stats = [
            'total' => $logs->count(),
            'passed' => $logs->where('status', 'OK')->count(),
            'failed' => $logs->where('status', 'FAILED')->count(),
            'warning' => $logs->where('status', 'WARNING')->count(),
        ];
        
        return view('admin.reports', compact('logs', 'stats'));
    }
    
    public function settings()
    {
        return view('admin.settings');
    }
    
    public function apiDocs()
    {
        return view('admin.api-docs');
    }
    
    public function network()
    {
        return view('admin.network');
    }
    
    // IoT Device Management placeholders
    public function temperature()
    {
        return view('admin.iot.temperature');
    }
    
    public function switches()
    {
        return view('admin.iot.switches');
    }
    
    public function environmental()
    {
        return view('admin.iot.environmental');
    }
}
