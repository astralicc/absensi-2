<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\DeviceLog;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'device_user_id' => 'required',
            'timestamp' => 'required|date'
        ]);

        // 1. Save raw device log
        $log = DeviceLog::create([
            'device_user_id' => $request->device_user_id,
            'timestamp' => $request->timestamp,
            'raw_payload' => json_encode($request->all()),
            'processed' => false
        ]);

        // 2. Find user based on device_user_id
        $user = Siswa::where('nis', $request->device_user_id)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $date = Carbon::parse($request->timestamp)->toDateString();

        // 3. Check if attendance already exists today
        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $date)
            ->first();

        if (!$attendance) {
            // First scan = CHECK IN
            Attendance::create([
                'user_id' => $user->id,
                'date' => $date,
                'check_in' => $request->timestamp
            ]);
        } elseif (!$attendance->check_out) {
            // Second scan = CHECK OUT
            $attendance->update([
                'check_out' => $request->timestamp
            ]);
        }

        // 4. Mark log as processed
        $log->update([
            'processed' => true
        ]);

        return response()->json([
            'device_user_id' => $request->device_user_id,
            'timestamp' => $request->timestamp
        ]);
    }

    /**
     * Display a listing of the resource.
     * List attendances with optional filters
     */
    public function index(Request $request)
    {
        $query = Attendance::query()->with('siswa:id,name,email,nis'); // eager load siswa

        // Filter by date
        if ($request->has('date')) {
            $query->where('date', $request->date);
        }

        // Filter by user
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $attendances = $query->get();

        if ($attendances->isEmpty()) {
            return response()->json([
                'message' => 'No attendance records found'
            ], 404);
        }

        return response()->json($attendances);
    }

    // Get raw device logs (optional)
    public function logs()
    {
        $logs = DeviceLog::orderBy('timestamp', 'desc')->get();

        if ($logs->isEmpty()) {
            return response()->json([
                'message' => 'No device logs found'
            ], 404);
        }

        return response()->json($logs);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
