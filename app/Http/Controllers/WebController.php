<?php

namespace App\Http\Controllers;

use App\Models\LogTester;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function dashboard()
    {
        $logs = LogTester::orderBy('tanggal_uji', 'desc')->get();
        return view('admin.dashboard', compact('logs'));
    }
}
