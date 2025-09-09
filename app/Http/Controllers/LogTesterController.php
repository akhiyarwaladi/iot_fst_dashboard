<?php

namespace App\Http\Controllers;

use App\Models\LogTester;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LogTesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $logs = LogTester::orderBy('tanggal_uji', 'desc')->get();
        return response()->json($logs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'komponen_terdeteksi' => 'required|string|max:255',
            'status' => 'required|string|max:50',
        ]);

        $log = LogTester::create($validated);
        return response()->json($log, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(LogTester $log): JsonResponse
    {
        return response()->json($log);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LogTester $log): JsonResponse
    {
        $validated = $request->validate([
            'komponen_terdeteksi' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|required|string|max:50',
        ]);

        $log->update($validated);
        return response()->json($log);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LogTester $log): JsonResponse
    {
        $log->delete();
        return response()->json(['message' => 'Log deleted successfully']);
    }

    /**
     * Filter logs by status.
     */
    public function byStatus(string $status): JsonResponse
    {
        $logs = LogTester::where('status', $status)
            ->orderBy('tanggal_uji', 'desc')
            ->get();
        return response()->json($logs);
    }
}
