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
    
    
    public function settings()
    {
        return view('admin.settings');
    }
    
    public function apiDocs()
    {
        return view('admin.api-docs');
    }
    
    public function logs()
    {
        $logs = LogTester::orderBy('tanggal_uji', 'desc')->get();
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
        $stats = [
            'total' => LogTester::count(),
            'passed' => LogTester::where('status', 'OK')->count(),
            'failed' => LogTester::where('status', 'FAILED')->count(),
            'warning' => LogTester::where('status', 'WARNING')->count(),
        ];
        return view('admin.reports', compact('stats'));
    }
    
    // Simple IoT Device Management pages
    public function temperature()
    {
        return view('admin.temperature');
    }
    
    public function switches()
    {
        return view('admin.switches');
    }
}
