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
}
