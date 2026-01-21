@extends('layouts.app')

@section('title', 'Employee Dashboard - Tible T&A')

@section('content')
    <div x-data="clockData()" x-init="init()">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ $user['name'] }}</h1>
            <p class="mt-2 text-gray-600">Track your time and view your attendance summary</p>
        </div>

        <!-- Clock In/Out Button Section -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-lg shadow-lg p-8 text-center">
                <div class="mb-4">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white bg-opacity-20 mb-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-white text-xl font-semibold">Current Status</h2>
                    <p class="text-white text-opacity-90 mt-1">
                        <span x-text="clockedIn ? 'You are currently clocked in' : 'You are currently clocked out'"></span>
                    </p>
                    <p x-show="clockedIn && clockInTime" class="text-white text-opacity-75 text-sm mt-1">
                        Since <span x-text="clockInTime"></span>
                    </p>
                </div>

                <button @click="toggleClock()" :disabled="loading"
                    class="clock-in-btn inline-flex items-center px-8 py-4 text-lg font-semibold rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transition-all duration-200"
                    :class="clockedIn ? 'bg-white text-primary-600 hover:bg-gray-50' : 'bg-green-500 text-white hover:bg-green-600'">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span x-text="loading ? 'Processing...' : (clockedIn ? 'Clock Out' : 'Clock In')"></span>
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Today's Hours -->
            <div class="stat-card bg-white rounded-lg shadow-md p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Today's Hours</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-1" x-text="todayHours.toFixed(1)">
                            {{ number_format($user['today_hours'], 1) }}</h3>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2">Hours worked today</p>
            </div>

            <!-- This Week -->
            <div class="stat-card bg-white rounded-lg shadow-md p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">This Week</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-1">
                            {{ number_format(array_sum($user['weekly_hours']), 1) }}</h3>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2">Total weekly hours</p>
            </div>

            <!-- Status -->
            <div class="stat-card bg-white rounded-lg shadow-md p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Status</p>
                        <h3 class="text-3xl font-bold mt-1" :class="clockedIn ? 'text-green-600' : 'text-gray-400'"
                            x-text="clockedIn ? 'Active' : 'Inactive'">{{ $user['clocked_in'] ? 'Active' : 'Inactive' }}
                        </h3>
                    </div>
                    <div class="rounded-full p-3" :class="clockedIn ? 'bg-green-100' : 'bg-gray-100'">
                        <svg class="w-6 h-6" :class="clockedIn ? 'text-green-600' : 'text-gray-400'" fill="currentColor"
                            viewBox="0 0 20 20">
                            <circle cx="10" cy="10" r="8" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2">Current clock status</p>
            </div>
        </div>

        <!-- Weekly Summary Chart -->
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Weekly Hours Summary</h3>
            <div class="space-y-4">
                @foreach($user['weekly_hours'] as $day => $hours)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-medium text-gray-700">{{ $day }}</span>
                            <span class="text-gray-600">{{ number_format($hours, 1) }} hrs</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-primary-600 h-3 rounded-full transition-all duration-500"
                                style="width: {{ min(($hours / 8) * 100, 100) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex justify-between text-sm">
                    <span class="font-semibold text-gray-700">Total Weekly Hours</span>
                    <span class="font-bold text-primary-600">{{ number_format(array_sum($user['weekly_hours']), 1) }}
                        hrs</span>
                </div>
            </div>
        </div>

        <!-- Today's Timeline -->
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Today's Timeline</h3>

            @if($user['clocked_in'] && $user['clock_in_time'])
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-green-100">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Clocked In</p>
                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($user['clock_in_time'])->format('h:i A') }}
                        </p>
                        <p class="text-xs text-green-600 mt-1">Currently active</p>
                    </div>
                </div>
            @elseif($user['today_hours'] > 0)
                <div class="space-y-4">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-100">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Total Today</p>
                            <p class="text-sm text-gray-600">{{ number_format($user['today_hours'], 2) }} hours worked</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">No clock-in activity today</p>
                    <p class="text-xs text-gray-400">Click "Clock In" to start tracking</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function clockData() {
            return {
                clockedIn: {{ $user['clocked_in'] ? 'true' : 'false' }},
                clockInTime: '{{ $user['clock_in_time'] ? \Carbon\Carbon::parse($user['clock_in_time'])->format('h:i A') : '' }}',
                todayHours: {{ $user['today_hours'] }},
                loading: false,

                init() {
                    // Update hours every minute if clocked in
                    setInterval(() => {
                        if (this.clockedIn) {
                            this.updateElapsedTime();
                        }
                    }, 60000);
                },

                updateElapsedTime() {
                    // This is a simple update - hours will be calculated on clock out
                },

                async toggleClock() {
                    this.loading = true;

                    try {
                        const response = await fetch('/clock', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({})
                        });

                        const data = await response.json();

                        if (data.success) {
                            this.clockedIn = data.clocked_in;
                            this.clockInTime = data.clock_in_time ? new Date(data.clock_in_time).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' }) : '';
                            this.todayHours = data.today_hours;

                            // Reload page to update UI fully
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        } else {
                            alert('Error: ' + (data.message || 'Failed to toggle clock'));
                        }
                    } catch (error) {
                        console.error('Clock error:', error);
                        alert('Failed to toggle clock status');
                    } finally {
                        this.loading = false;
                    }
                }
            };
        }
    </script>
@endsection