<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the appropriate dashboard based on user role
     */
    public function index()
    {
        $user = session('user');

        if (!$user) {
            return redirect('/login');
        }

        // Route to appropriate dashboard based on role
        if ($user['role'] === 'employee') {
            return view('dashboard.employee', ['user' => $user]);
        } else if ($user['role'] === 'manager' || $user['role'] === 'admin') {
            $teamData = session('team_data', []);
            return view('dashboard.manager', ['user' => $user, 'teamData' => $teamData]);
        }

        return redirect('/login');
    }

    /**
     * Handle clock in/out toggle (AJAX endpoint)
     */
    public function clock(Request $request)
    {
        $user = session('user');

        if (!$user) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }

        // Toggle clock status
        $user['clocked_in'] = !$user['clocked_in'];

        if ($user['clocked_in']) {
            // Clock in
            $user['clock_in_time'] = now()->format('Y-m-d H:i:s');
            $message = 'Clocked in successfully';
            $status = 'in';
        } else {
            // Clock out - calculate hours worked
            if ($user['clock_in_time']) {
                $clockInTime = \Carbon\Carbon::parse($user['clock_in_time']);
                $hoursWorked = $clockInTime->diffInMinutes(now()) / 60;
                $user['today_hours'] += $hoursWorked;

                // Update weekly hours (add to current day)
                $dayOfWeek = now()->format('D'); // Mon, Tue, etc.
                $user['weekly_hours'][$dayOfWeek] = ($user['weekly_hours'][$dayOfWeek] ?? 0) + $hoursWorked;
            }
            $user['clock_in_time'] = null;
            $message = 'Clocked out successfully';
            $status = 'out';
        }

        // Update session
        session()->put('user', $user);

        return response()->json([
            'success' => true,
            'message' => $message,
            'status' => $status,
            'clocked_in' => $user['clocked_in'],
            'clock_in_time' => $user['clock_in_time'],
            'today_hours' => round($user['today_hours'], 2)
        ]);
    }

    /**
     * Show employee details page
     */
    public function employeeDetails($id)
    {
        $user = session('user');

        // Only managers and admins can view employee details
        if (!$user || !in_array($user['role'], ['manager', 'admin'])) {
            return redirect('/dashboard')->with('error', 'Access denied');
        }

        // Get employee data (from team data or create detailed profile)
        $teamData = session('team_data', []);
        $employee = null;

        // Find employee in team data
        foreach ($teamData['employees'] ?? [] as $emp) {
            if ($emp['name'] === urldecode($id)) {
                $employee = $emp;
                break;
            }
        }

        // If not found, use first employee as default
        if (!$employee && isset($teamData['employees'][0])) {
            $employee = $teamData['employees'][0];
        }

        // If still no employee, create default
        if (!$employee) {
            $employee = [
                'name' => 'John Smith',
                'status' => 'In',
                'hours' => 6.2,
                'clock_in' => '09:15 AM',
                'late' => false
            ];
        }

        // Build detailed employee profile
        $employeeDetails = [
            'name' => $employee['name'],
            'role' => 'UI/UX Designer',
            'email' => strtolower(str_replace(' ', '', $employee['name'])) . '@tible.com',
            'phone' => '0703080304',
            'last_active' => 'Last active time is today - 3:37 PM',
            'badges' => ['Admin', 'Full time'],
            'current_status' => $employee['status'],

            // Attendance summary for January 2023
            'month' => 'January 2023',
            'summary' => [
                'scheduled' => '208 hr 30 min',
                'total_duty' => '215 hr 15 min',
                'total_working' => '4 Hr 30 min (3 Late ins)',
                'difference' => '+ 7 hr 30 min',
                'incomplete_records' => 2,
                'missed_shift' => 2,
                'absence' => 1,
                'approved_ot' => '+ 2 hr 10 min',
                'early_out' => '1 hr 5 min (1 Early Out)'
            ],

            // Detailed attendance records
            'attendance_records' => [
                [
                    'date' => 'Sunday, 1 Jan 2023',
                    'status' => 'Present',
                    'scheduled' => '9 am - 6 pm',
                    'shift_note' => '@10+ Shift A',
                    'check_in' => '9:00 am',
                    'check_out' => '6:00 pm',
                    'worked' => '9 hr 00 min',
                    'difference' => '',
                    'badge_color' => 'green'
                ],
                [
                    'date' => 'Monday, 2 Jan 2023',
                    'status' => 'Present',
                    'scheduled' => '9 am - 6 pm',
                    'shift_note' => '@10+ Shift A',
                    'check_in' => '8:50 am',
                    'check_in_badge' => 'Early In',
                    'check_out' => '5:30 pm',
                    'check_out_badge' => 'Early Out',
                    'worked' => '8 hr 40 min',
                    'difference' => '-20 min',
                    'badge_color' => 'green',
                    'diff_color' => 'orange'
                ],
                [
                    'date' => 'Tuesday, 3 Jan 2023',
                    'status' => 'Present',
                    'scheduled' => '9 am - 6 pm',
                    'shift_note' => '@10+ Shift A',
                    'check_in' => '9:00 am',
                    'check_out' => '7:30 am',
                    'worked' => '9 hr 30 min',
                    'difference' => '+ 1 hr 30 min',
                    'badge_color' => 'green',
                    'diff_color' => 'green'
                ],
                [
                    'date' => 'Wednesday, 4 Jan 2023',
                    'status' => 'Absent',
                    'scheduled' => '9 am - 6 pm',
                    'shift_note' => '@10+ Shift A',
                    'check_in' => 'No Record',
                    'check_out' => 'No Record',
                    'worked' => '--',
                    'difference' => '-9 hr',
                    'badge_color' => 'red',
                    'diff_color' => 'red'
                ],
                [
                    'date' => 'Thursday, 5 Jan 2023',
                    'status' => 'Holiday',
                    'scheduled' => 'Day off',
                    'shift_note' => 'Public holiday',
                    'check_in' => '--',
                    'check_out' => '--',
                    'worked' => '--',
                    'difference' => '--',
                    'badge_color' => 'gray'
                ],
                [
                    'date' => 'Saturday, 7 Jan 2023',
                    'status' => 'Leave',
                    'scheduled' => 'Leave',
                    'shift_note' => 'Sick leave',
                    'check_in' => '--',
                    'check_out' => 'Sick Leave',
                    'worked' => '--',
                    'difference' => '--',
                    'badge_color' => 'blue'
                ]
            ]
        ];

        return view('dashboard.employee-details', [
            'employee' => $employeeDetails,
            'user' => $user
        ]);
    }
}
