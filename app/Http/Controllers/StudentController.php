<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceRecord;
use App\Models\Session;
use App\Models\Student;

class StudentController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        if (!$user || $user->role !== 'Student' || !$user->student) {
            $dashboardRoute = $user && method_exists($user, 'dashboardRoute') ? $user->dashboardRoute() : 'login';

            return redirect()->route($dashboardRoute)
                ->with('error', 'Student account is required to access this dashboard.');
        }

        $student = $user->student;
        $attendanceRecords = AttendanceRecord::with(['session.module', 'session.centre'])
            ->where('student_id', $student->student_id)
            ->orderBy('scan_time', 'desc')
            ->get();

        return view('student.dashboard', compact('student', 'attendanceRecords'));
    }

    public function scan()
    {
        return view('student.scan');
    }

    public function validateAttendance(Request $request)
    {
        $user = auth()->user();

        if (!$user || $user->role !== 'Student' || !$user->student) {
            return response()->json([
                'success' => false,
                'message' => 'Student account is required to record attendance.',
            ], 403);
        }

        $request->validate([
            'qr_token' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $session = Session::where('qr_token', $request->qr_token)
            ->where('status', 'Active')
            ->first();

        if (!$session) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired QR code.'
            ], 400);
        }

        if ($session->qr_expires_at->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'QR code has expired.'
            ], 400);
        }

        $student = $user->student;

        // Check if already marked attendance
        $existing = AttendanceRecord::where('session_id', $session->session_id)
            ->where('student_id', $student->student_id)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Attendance already recorded for this session.'
            ], 400);
        }

        // Calculate distance using Haversine formula
        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $session->centre->latitude,
            $session->centre->longitude
        );

        $status = $distance <= $session->centre->radius_m ? 'Present' : 'Flagged';

        AttendanceRecord::create([
            'session_id' => $session->session_id,
            'student_id' => $student->student_id,
            'scan_time' => now(),
            'scan_lat' => $request->latitude,
            'scan_lng' => $request->longitude,
            'distance_m' => $distance,
            'status' => $status,
        ]);

        return response()->json([
            'success' => true,
            'message' => $status === 'Present' 
                ? 'Attendance recorded successfully!' 
                : 'Attendance recorded but flagged due to location discrepancy.',
            'status' => $status,
            'distance' => round($distance, 2),
        ]);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Earth's radius in meters

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }
}
