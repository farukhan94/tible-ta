@extends('layouts.app')

@section('title', 'Employee Details - Tible T&A')

@section('content')
    <div>
        <!-- Back Button -->
        <div class="mb-4">
            <a href="/dashboard" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 transition">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Dashboard
            </a>
        </div>

        <!-- Employee Profile Card -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6 border border-gray-200">
            <div class="flex items-start space-x-6">
                <!-- Profile Picture -->
                <div class="flex-shrink-0">
                    <div
                        class="h-20 w-20 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                        {{ substr($employee['name'], 0, 1) }}
                    </div>
                    @if($employee['current_status'] === 'In')
                        <div class="mt-2 flex items-center justify-center">
                            <span class="flex h-3 w-3 relative">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                            </span>
                            <span class="ml-2 text-xs text-green-600 font-medium">Online</span>
                        </div>
                    @endif
                </div>

                <!-- Employee Info -->
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-2">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $employee['name'] }}</h1>
                        @foreach($employee['badges'] as $badge)
                            <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                {{ $badge === 'Admin' ? 'bg-purple-100 text-purple-700' : 'bg-green-100 text-green-700' }}">
                                {{ $badge }}
                            </span>
                        @endforeach
                    </div>
                    <p class="text-gray-600 mb-3">{{ $employee['role'] }}</p>

                    <!-- Contact Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                        <div class="flex items-center text-gray-700">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ $employee['email'] }}
                        </div>
                        <div class="flex items-center text-gray-700">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            {{ $employee['phone'] }}
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $employee['last_active'] }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="bg-white rounded-t-lg shadow-sm border border-gray-200 border-b-0">
            <div class="flex overflow-x-auto">
                <button
                    class="px-6 py-3 text-sm font-medium border-b-2 border-primary-500 text-primary-600 whitespace-nowrap">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Attendance & Leave
                </button>
                <button
                    class="px-6 py-3 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    Personal
                </button>
                <button
                    class="px-6 py-3 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    Organization
                </button>
                <button
                    class="px-6 py-3 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    Payroll & Finance
                </button>
                <button
                    class="px-6 py-3 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    Learning & Development
                </button>
                <button
                    class="px-6 py-3 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 whitespace-nowrap">
                    Benefits
                </button>
            </div>
        </div>

        <!-- Attendance Content -->
        <div class="bg-white rounded-b-lg shadow-md p-6 border border-gray-200">
            <!-- Month Selector & Actions -->
            <div class="flex flex-wrap items-center justify-between mb-6 gap-4">
                <div class="flex items-center space-x-4">
                    <button class="p-2 hover:bg-gray-100 rounded transition">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <h2 class="text-lg font-semibold text-gray-900">{{ $employee['month'] }}</h2>
                    <button class="p-2 hover:bg-gray-100 rounded transition">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    <button class="px-4 py-2 text-sm border border-gray-300 rounded-md hover:bg-gray-50 transition">
                        Monthly
                        <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>
                <button class="px-4 py-2 text-sm bg-primary-600 text-white rounded-md hover:bg-primary-700 transition">
                    + New Request
                </button>
            </div>

            <!-- Attendance Tabs -->
            <div class="flex border-b border-gray-200 mb-6">
                <button class="px-4 py-2 text-sm font-medium border-b-2 border-primary-500 text-primary-600">
                    Attendance
                </button>
                <button
                    class="px-4 py-2 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                    Leaves
                </button>
                <button
                    class="px-4 py-2 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                    View Job card
                </button>
            </div>

            <!-- Summary Section -->
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-4">Summary</h3>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-600 mb-1">Scheduled</p>
                        <p class="text-lg font-bold text-gray-900">{{ $employee['summary']['scheduled'] }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-600 mb-1">Total Duty</p>
                        <p class="text-lg font-bold text-gray-900">{{ $employee['summary']['total_duty'] }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-600 mb-1">Total Working</p>
                        <p class="text-lg font-bold text-gray-900">{{ $employee['summary']['total_working'] }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-600 mb-1">Difference</p>
                        <p class="text-lg font-bold text-green-600">{{ $employee['summary']['difference'] }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-600 mb-1">Incomplete records</p>
                        <p class="text-lg font-bold text-orange-600">{{ $employee['summary']['incomplete_records'] }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-600 mb-1">Missed Shift</p>
                        <p class="text-lg font-bold text-gray-900">{{ $employee['summary']['missed_shift'] }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-600 mb-1">Absence</p>
                        <p class="text-lg font-bold text-gray-900">{{ $employee['summary']['absence'] }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-600 mb-1">Approved OT</p>
                        <p class="text-lg font-bold text-green-600">{{ $employee['summary']['approved_ot'] }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-xs text-gray-600 mb-1">Early Out</p>
                        <p class="text-lg font-bold text-gray-900">{{ $employee['summary']['early_out'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Attendance Records Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Scheduled
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check In</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check Out</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Worked</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Difference</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($employee['attendance_records'] as $record)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-4 text-sm text-gray-900">{{ $record['date'] }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                        @if($record['badge_color'] === 'green') bg-green-100 text-green-700
                                        @elseif($record['badge_color'] === 'red') bg-red-100 text-red-700
                                        @elseif($record['badge_color'] === 'blue') bg-blue-100 text-blue-700
                                        @else bg-gray-100 text-gray-700
                                        @endif">
                                        {{ $record['status'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm">
                                    <div class="text-gray-900">{{ $record['scheduled'] }}</div>
                                    @if(isset($record['shift_note']))
                                        <div class="text-xs text-gray-500">{{ $record['shift_note'] }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-sm">
                                    <div class="text-gray-900">{{ $record['check_in'] }}</div>
                                    @if(isset($record['check_in_badge']))
                                        <span class="text-xs text-green-600">{{ $record['check_in_badge'] }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-sm">
                                    <div class="text-gray-900">{{ $record['check_out'] }}</div>
                                    @if(isset($record['check_out_badge']))
                                        <span class="text-xs text-orange-600">{{ $record['check_out_badge'] }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-sm font-medium text-gray-900">{{ $record['worked'] }}</td>
                                <td class="px-4 py-4 text-sm font-medium
                                    @if(isset($record['diff_color']) && $record['diff_color'] === 'green') text-green-600
                                    @elseif(isset($record['diff_color']) && $record['diff_color'] === 'orange') text-orange-600
                                    @elseif(isset($record['diff_color']) && $record['diff_color'] === 'red') text-red-600
                                    @else text-gray-900
                                    @endif">
                                    {{ $record['difference'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection