<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Fake user credentials for demo
     */
    private $users = [
        'employee@test.com' => [
            'password' => 'pass',
            'name' => 'Mohammad Farhan Khan',
            'role' => 'employee',
            'id' => 1
        ],
        'manager@test.com' => [
            'password' => 'pass',
            'name' => 'IT Manager',
            'role' => 'manager',
            'id' => 2
        ],
        'admin@test.com' => [
            'password' => 'pass',
            'name' => 'Admin',
            'role' => 'admin',
            'id' => 3
        ]
    ];

    /**
     * Show the login form
     */
    public function showLogin()
    {
        // Redirect if already logged in
        if (session()->has('user')) {
            return redirect('/dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle login request with fake authentication
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $email = $request->email;
        $password = $request->password;

        // Check if user exists and password matches
        if (isset($this->users[$email]) && $this->users[$email]['password'] === $password) {
            $user = $this->users[$email];

            // Initialize session with user data
            session()->put('user', [
                'id' => $user['id'],
                'name' => $user['name'],
                'role' => $user['role'],
                'email' => $email,
                'clocked_in' => false,
                'clock_in_time' => null,
                'today_hours' => 0,
                'weekly_hours' => [
                    'Mon' => 0,
                    'Tue' => 0,
                    'Wed' => 0,
                    'Thu' => 0,
                    'Fri' => 0,
                    'Sat' => 0,
                    'Sun' => 0
                ]
            ]);

            // For manager role, add fake team data
            if ($user['role'] === 'manager' || $user['role'] === 'admin') {
                $this->initializeTeamData();
            }

            return redirect('/dashboard');
        }

        // Login failed
        return back()->withErrors([
            'email' => 'Invalid credentials. Please use the demo accounts provided.'
        ])->withInput($request->except('password'));
    }

    /**
     * Handle logout
     */
    public function logout()
    {
        session()->flush();
        return redirect('/login')->with('message', 'You have been logged out successfully.');
    }

    /**
     * Initialize fake team data for managers
     */
    private function initializeTeamData()
    {
        session()->put('team_data', [
            'employees' => [
                [
                    'name' => 'John Smith',
                    'status' => 'In',
                    'hours' => 6.2,
                    'clock_in' => '09:15 AM',
                    'late' => false
                ],
                [
                    'name' => 'Sarah Johnson',
                    'status' => 'Out',
                    'hours' => 8.0,
                    'clock_in' => '08:45 AM',
                    'late' => false
                ],
                [
                    'name' => 'Mike Wilson',
                    'status' => 'In',
                    'hours' => 7.5,
                    'clock_in' => '09:35 AM',
                    'late' => true
                ],
                [
                    'name' => 'Emily Davis',
                    'status' => 'In',
                    'hours' => 5.8,
                    'clock_in' => '08:50 AM',
                    'late' => false
                ],
                [
                    'name' => 'David Brown',
                    'status' => 'Out',
                    'hours' => 8.5,
                    'clock_in' => '08:30 AM',
                    'late' => false
                ]
            ],
            'weekly_team_hours' => [
                'Mon' => 42.5,
                'Tue' => 39.8,
                'Wed' => 41.2,
                'Thu' => 40.0,
                'Fri' => 38.5,
                'Sat' => 0,
                'Sun' => 0
            ]
        ]);
    }
}
