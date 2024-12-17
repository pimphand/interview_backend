<?php

namespace App\Http\Controllers;

use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $data = Attendance::whereBetween('attendance_date', [$request->start_date, $request->end_date])
            ->paginate(10);

        return AttendanceResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function checkIn(Request $request): \Illuminate\Http\JsonResponse
    {
        // Validate check user active or not
        $user = Auth::user();

        if ($user->is_active === 0) {
            return response()->json(['message' => 'User is not active'], 400);
        }

        $attendanceDate = now()->toDateString();

        $attendance = Attendance::where('user_id', $user->id)
            ->where('attendance_date', $attendanceDate)
            ->first();

        if ($attendance) {
            return response()->json(['message' => 'You have already checked in for today'], 400);
        }

        $checkInTime = now();
        $officeStartTime = Carbon::createFromTime(9, 0, 0); // Jam masuk kantor, misalnya 09:00 pagi
        $status = 'Present';

        if ($checkInTime->greaterThan($officeStartTime)) {
            $status = 'Late';
        }

        $user->attendance()->create([
            'attendance_date' => $attendanceDate,
            'check_in' => $checkInTime->toTimeString(),
            'status_check_in' => $status,
        ]);

        return response()->json(['message' => 'Check-in successful']);
    }

    public function checkOut(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        if ($user->is_active === 0) {
            return response()->json(['message' => 'User is not active'], 400);
        }

        $attendanceDate = now()->toDateString();

        // Validation to ensure no duplicate attendance for the same day
        $attendance = Attendance::where('attendance_date', $attendanceDate)
                    ->where('user_id', $user->id)
                    ->first();

        if (!$attendance) {
            return response()->json(['message' => 'You have not checked in for today'], 400);
        }

        if ($attendance->check_out) {
            return response()->json(['message' => 'You have already checked out for today'], 400);
        }

        $checkInTime = now();
        $officeEndTime = Carbon::createFromTime(18, 0, 0); // Maximum leave time 6:00 PM

        $status = $checkInTime->lessThan($officeEndTime) ? 'Early Leave' : ($checkInTime->greaterThan($officeEndTime) ? 'Over Time' : 'Leave');

        $user->attendance()->where('attendance_date', $attendanceDate)->update([
            'check_out' => $checkInTime->toTimeString(),
            'status_check_out' => $status
        ]);

        return response()->json(['message' => 'Check-in successful']);
    }
}
