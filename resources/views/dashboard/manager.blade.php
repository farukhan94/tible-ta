@extends('layouts.app')

@section('title', 'Manager Dashboard - Tible T&A')

@section('content')
    <div>
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Manager Dashboard</h1>
            <p class="mt-2 text-gray-600">Monitor team attendance and productivity</p>
        </div>

        <!-- Summary Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Team Members -->
            <div class="stat-card bg-white rounded-lg shadow-md p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Team Members</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ count($teamData['employees'] ?? []) }}</h3>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Currently Active -->
            <div class="stat-card bg-white rounded-lg shadow-md p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Currently Active</p>
                        @php
                            $activeCount = collect($teamData['employees'] ?? [])->where('status', 'In')->count();
                        @endphp
                        <h3 class="text-3xl font-bold text-green-600 mt-1">{{ $activeCount }}</h3>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <circle cx="10" cy="10" r="8" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Late Arrivals -->
            <div class="stat-card bg-white rounded-lg shadow-md p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Late Today</p>
                        @php
                            $lateCount = collect($teamData['employees'] ?? [])->where('late', true)->count();
                        @endphp
                        <h3 class="text-3xl font-bold mt-1" :class="$lateCount > 0 ? 'text-orange-600' : 'text-gray-900'">
                            {{ $lateCount }}
                        </h3>
                    </div>
                    <div class="rounded-full p-3" :class="$lateCount > 0 ? 'bg-orange-100' : 'bg-gray-100'">
                        <svg class="w-6 h-6" :class="$lateCount > 0 ? 'text-orange-600' : 'text-gray-400'" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Average Hours -->
            <div class="stat-card bg-white rounded-lg shadow-md p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Avg Hours Today</p>
                        @php
                            $avgHours = count($teamData['employees'] ?? []) > 0
                                ? collect($teamData['employees'])->avg('hours')
                                : 0;
                        @endphp
                        <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($avgHours, 1) }}</h3>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Late Arrivals Alert -->
        @if($lateCount > 0)
            <div class="bg-orange-50 border-l-4 border-orange-400 p-4 mb-6 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-orange-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-orange-800">Late Arrival Alert</h3>
                        <p class="text-sm text-orange-700 mt-1">
                            {{ $lateCount }} team member(s) arrived late today.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Team Overview Table -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 mb-8 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Team Overview</h3>
                <p class="text-sm text-gray-600 mt-1">Current status and hours for all team members</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Employee Name
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Clock In Time
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Hours Today
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Late Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($teamData['employees'] ?? [] as $employee)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                                                <span class="text-primary-700 font-semibold text-sm">
                                                    {{ substr($employee['name'], 0, 1) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <a href="/employee/{{ urlencode($employee['name']) }}"
                                                class="text-sm font-medium text-primary-600 hover:text-primary-800 hover:underline transition">
                                                {{ $employee['name'] }}
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($employee['status'] === 'In')
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Clocked In
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Clocked Out
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $employee['clock_in'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="font-semibold">{{ number_format($employee['hours'], 1) }}</span> hrs
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($employee['late'])
                                        <span class="text-orange-600 font-medium">Late</span>
                                    @else
                                        <span class="text-green-600 font-medium">On Time</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Weekly Team Hours Chart -->
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Weekly Team Hours</h3>
            <div class="space-y-4">
                @foreach($teamData['weekly_team_hours'] ?? [] as $day => $hours)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-medium text-gray-700">{{ $day }}</span>
                            <span class="text-gray-600">{{ number_format($hours, 1) }} hrs total</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div class="bg-gradient-to-r from-primary-500 to-primary-600 h-4 rounded-full transition-all duration-500 flex items-center justify-end pr-2"
                                style="width: {{ min(($hours / 50) * 100, 100) }}%">
                                @if($hours > 0)
                                    <span class="text-xs text-white font-medium">{{ number_format($hours, 0) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6 pt-4 border-t border-gray-200">
                <div class="flex justify-between text-sm">
                    <span class="font-semibold text-gray-700">Total Weekly Hours</span>
                    <span
                        class="font-bold text-primary-600">{{ number_format(array_sum($teamData['weekly_team_hours'] ?? []), 1) }}
                        hrs</span>
                </div>
                <div class="flex justify-between text-xs text-gray-500 mt-1">
                    <span>All team members combined</span>
                    <span>{{ count($teamData['employees'] ?? []) }} employees</span>
                </div>
            </div>
        </div>
    </div>
@endsection