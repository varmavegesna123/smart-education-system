@extends('layouts.portal')

@section('title', 'Teacher Portal')
@section('header_title', 'Class Analytics')

@section('sidebar_links')
    <a href="{{ route('teacher.dashboard') }}" class="nav-link active flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
        Overview
    </a>
    <a href="{{ route('teacher.attendance') }}" class="nav-link flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium text-zinc-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
        Attendance
    </a>
    <a href="{{ route('teacher.assignments') }}" class="nav-link flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium text-zinc-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
        Assignments
    </a>
@endsection

@section('content')
<div x-data="{ showCourseModal: false }">
    <!-- Header with Action -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">Executive Overview</h2>
            <p class="text-zinc-500 text-sm">Managing {{ $teacher->classRooms->count() }} active classes</p>
        </div>
        <button @click="showCourseModal = true" class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-sm font-bold transition duration-200 shadow-lg shadow-emerald-500/20 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Create New Class
        </button>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Top KPIs -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- KPI 1 -->
        <div class="premium-card rounded-xl p-4 flex flex-col justify-between h-24">
            <div class="flex justify-between items-start">
                <p class="text-[10px] font-semibold text-zinc-500 uppercase tracking-wider">Total Students</p>
                <span class="flex items-center text-[10px] font-medium text-emerald-500">
                    <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    12%
                </span>
            </div>
            <div class="flex items-end justify-between">
                <span class="text-2xl font-semibold text-zinc-100 tracking-tight leading-none">{{ $totalStudents ?? 42 }}</span>
                <!-- Mini Sparkline placeholder -->
                <div class="w-16 h-4 opacity-50 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMjAiPjxwYXRoIGQ9Ik0wIDIwTDIwIDEwTDM1IDE1TDUwIDVMODAgMTBMMTAwIDAiIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzEwYjk4MSIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz48L3N2Zz4=')] bg-no-repeat bg-center"></div>
            </div>
        </div>

        <!-- KPI 2 -->
        <div class="premium-card rounded-xl p-4 flex flex-col justify-between h-24">
            <div class="flex justify-between items-start">
                <p class="text-[10px] font-semibold text-zinc-500 uppercase tracking-wider">Class Average</p>
                <span class="flex items-center text-[10px] font-medium text-amber-500">
                    <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                    1.5%
                </span>
            </div>
            <div class="flex items-end justify-between">
                <span class="text-2xl font-semibold text-zinc-100 tracking-tight leading-none">76%</span>
                <div class="w-16 h-4 opacity-50 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMjAiPjxwYXRoIGQ9Ik0wIDEwTDIwIDE1TDM1IDVMMTUwIDE1TDgwIDEwTDEwMCAyMCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjZjU5ZTBiIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPjwvc3ZnPg==')] bg-no-repeat bg-center"></div>
            </div>
        </div>

        <!-- KPI 3 -->
        <div class="premium-card rounded-xl p-4 flex flex-col justify-between h-24 relative overflow-hidden group">
            <div class="absolute inset-0 bg-red-500/5 group-hover:bg-red-500/10 transition-colors"></div>
            <div class="relative z-10 flex justify-between items-start">
                <p class="text-[10px] font-semibold text-red-500/80 uppercase tracking-wider">At Risk Students</p>
            </div>
            <div class="relative z-10 flex items-end justify-between">
                <span class="text-2xl font-semibold text-red-400 tracking-tight leading-none">{{ $slowLearnersCount ?? 3 }}</span>
                <span class="text-[10px] text-zinc-400 font-medium">Needs Attention</span>
            </div>
        </div>

        <!-- KPI 4 -->
        <div class="premium-card rounded-xl p-4 flex flex-col justify-between h-24">
            <div class="flex justify-between items-start">
                <p class="text-[10px] font-semibold text-zinc-500 uppercase tracking-wider">Attendance Rate</p>
                <span class="flex items-center text-[10px] font-medium text-emerald-500">
                    <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    4%
                </span>
            </div>
            <div class="flex items-end justify-between">
                <span class="text-2xl font-semibold text-zinc-100 tracking-tight leading-none">94%</span>
                <div class="w-16 h-4 opacity-50 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMjAiPjxwYXRoIGQ9Ik0wIDEwTDIwIDVMMzUgMTBMNTAgMEw4MCA1TDEwMCAwIiBmaWxsPSJub25lIiBzdHJva2U9IiMxMGI5ODEiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+PC9zdmc+')] bg-no-repeat bg-center"></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Pending Enrollment Requests -->
            @if(isset($pendingRequests) && $pendingRequests->count() > 0)
            <div class="premium-card rounded-xl overflow-hidden flex flex-col">
                <div class="p-4 border-b border-white/5 flex justify-between items-center bg-amber-500/10">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <h3 class="text-xs font-semibold text-amber-500 uppercase tracking-wider">Pending Enrollments</h3>
                        <span class="px-2 py-0.5 rounded-full bg-amber-500/20 text-[10px] text-amber-400 font-medium">{{ $pendingRequests->count() }} New</span>
                    </div>
                </div>
                <div class="divide-y divide-white/5">
                    @foreach($pendingRequests as $request)
                    <div class="flex items-center justify-between p-4 hover:bg-white/[0.02] transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-zinc-800 flex items-center justify-center text-xs font-bold text-zinc-300 border border-white/10">
                                {{ substr($request->student->user->name ?? 'S', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm text-zinc-100 font-medium">{{ $request->student->user->name ?? 'Unknown Student' }}</p>
                                <p class="text-[10px] text-zinc-500">Requested to join: {{ $request->classRoom->name }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <form action="{{ route('teacher.enrollment.approve', $request->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-500 border border-emerald-500/20 rounded text-xs font-medium transition-colors">Approve</button>
                            </form>
                            <form action="{{ route('teacher.enrollment.reject', $request->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 bg-red-500/10 hover:bg-red-500/20 text-red-500 border border-red-500/20 rounded text-xs font-medium transition-colors">Reject</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Data Table: Student Roster -->
            <div class="premium-card rounded-xl overflow-hidden flex flex-col min-h-[500px]">
            <div class="p-4 border-b border-white/5 flex justify-between items-center bg-zinc-900/30">
                <div class="flex items-center gap-3">
                    <h3 class="text-xs font-semibold text-zinc-100 uppercase tracking-wider">Student Roster</h3>
                    <span class="px-2 py-0.5 rounded-full bg-white/5 border border-white/10 text-[10px] text-zinc-400 font-medium">{{ $totalStudents ?? 42 }} Total</span>
                </div>
                
                <div class="flex gap-2">
                    <div class="relative">
                        <select class="appearance-none bg-zinc-900 border border-white/10 text-zinc-300 text-[10px] font-medium rounded px-3 py-1.5 pr-8 focus:outline-none focus:border-emerald-500/50 transition-colors">
                            <option>All Statuses</option>
                            <option>At Risk</option>
                            <option>Average</option>
                            <option>Excelling</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-zinc-500">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex-1 overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead class="sticky top-0 bg-zinc-900/80 backdrop-blur-md z-10 border-b border-white/5">
                        <tr class="text-[10px] text-zinc-500 uppercase tracking-wider">
                            <th class="py-3 pl-4 font-medium">Student Name</th>
                            <th class="py-3 font-medium">Performance</th>
                            <th class="py-3 font-medium">Attendance</th>
                            <th class="py-3 font-medium">AI Risk Status</th>
                            <th class="py-3 pr-4 text-right font-medium">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs divide-y divide-white/5">
                        @if(isset($roster) && count($roster) > 0)
                            @foreach($roster as $student)
                            <tr class="hover:bg-white/[0.02] transition-colors group">
                                <td class="py-3 pl-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-6 h-6 rounded-full bg-zinc-800 flex items-center justify-center text-[10px] font-medium text-zinc-400 border border-white/5">
                                            {{ substr($student['name'], 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-zinc-200 font-medium">{{ $student['name'] }}</p>
                                            <p class="text-[10px] text-zinc-500">{{ $student['email'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-6 text-right font-medium text-zinc-300">{{ $student['percentage'] }}%</span>
                                        <div class="w-16 h-1 bg-zinc-800 rounded-full overflow-hidden">
                                            @php $barColor = $student['percentage'] < 40 ? 'bg-red-500' : ($student['percentage'] < 70 ? 'bg-amber-500' : 'bg-emerald-500'); @endphp
                                            <div class="{{ $barColor }} h-full" style="width: {{ $student['percentage'] }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 text-zinc-400 font-medium">
                                    {{ rand(70, 98) }}%
                                </td>
                                <td class="py-3">
                                    @if($student['percentage'] < 40)
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-medium bg-red-500/10 text-red-500 border border-red-500/20 shadow-[0_0_8px_rgba(239,68,68,0.15)] relative">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                            High Risk
                                        </span>
                                    @elseif($student['percentage'] < 70)
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-medium bg-amber-500/10 text-amber-500 border border-amber-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Monitor
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            On Track
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 pr-4 text-right">
                                    <button class="text-zinc-500 hover:text-white p-1 rounded hover:bg-white/10 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <!-- Dummy Data for Layout Preview -->
                            <tr class="hover:bg-white/[0.02] transition-colors group">
                                <td class="py-3 pl-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-6 h-6 rounded-full bg-zinc-800 flex items-center justify-center text-[10px] font-medium text-zinc-400 border border-white/5">J</div>
                                        <div>
                                            <p class="text-zinc-200 font-medium">John Doe</p>
                                            <p class="text-[10px] text-zinc-500">john@example.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-6 text-right font-medium text-zinc-300">32%</span>
                                        <div class="w-16 h-1 bg-zinc-800 rounded-full overflow-hidden">
                                            <div class="bg-red-500 h-full" style="width: 32%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 text-zinc-400 font-medium">65%</td>
                                <td class="py-3">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-medium bg-red-500/10 text-red-500 border border-red-500/20 shadow-[0_0_8px_rgba(239,68,68,0.15)] relative">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                        High Risk
                                    </span>
                                </td>
                                <td class="py-3 pr-4 text-right">
                                    <button class="text-zinc-500 hover:text-white p-1 rounded hover:bg-white/10 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                    </button>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="p-3 border-t border-white/5 bg-zinc-900/30 flex justify-center">
                <button class="text-[10px] font-medium text-zinc-500 hover:text-zinc-300 transition-colors">Load More Students</button>
            </div>
        </div>
        </div>

        <!-- Right Column: Analytics & AI Alerts -->
        <div class="space-y-6">
            
            <!-- Class Trend Chart -->
            <div class="premium-card rounded-xl p-5">
                <h3 class="text-xs font-semibold text-zinc-100 uppercase tracking-wider mb-4">Class Performance Trend</h3>
                <div class="h-48 relative w-full">
                    <canvas id="classTrendChart"></canvas>
                </div>
            </div>

            <!-- AI Risk Alerts -->
            <div class="premium-card rounded-xl p-5 flex flex-col">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    <h3 class="text-xs font-semibold text-zinc-100 uppercase tracking-wider">AI Risk Detection</h3>
                </div>
                
                <div class="space-y-3">
                    <div class="p-3 rounded-lg bg-zinc-900/50 border border-white/5 group relative overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-0.5 bg-red-500"></div>
                        <div class="flex justify-between items-start mb-1.5">
                            <span class="text-xs text-zinc-200 font-medium">Critical Intervention</span>
                            <span class="text-[10px] text-red-500 font-medium">95% Confidence</span>
                        </div>
                        <p class="text-[11px] text-zinc-400 leading-relaxed">3 students have missed 4 consecutive assignments. Auto-remedial action recommended.</p>
                        <button class="mt-2 text-[10px] text-emerald-500 font-medium hover:text-emerald-400">Trigger Auto-Remedial &rarr;</button>
                    </div>

                    <div class="p-3 rounded-lg bg-zinc-900/50 border border-white/5 group relative overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-0.5 bg-amber-500"></div>
                        <div class="flex justify-between items-start mb-1.5">
                            <span class="text-xs text-zinc-200 font-medium">Downward Trend</span>
                            <span class="text-[10px] text-amber-500 font-medium">82% Confidence</span>
                        </div>
                        <p class="text-[11px] text-zinc-400 leading-relaxed">Overall class average in Physics dropped by 4% this week.</p>
                        <button class="mt-2 text-[10px] text-zinc-500 font-medium hover:text-zinc-300">View Module Analysis</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Create Course Modal -->
    <div x-show="showCourseModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showCourseModal" @click="showCourseModal = false" class="fixed inset-0 transition-opacity bg-black/60 backdrop-blur-sm"></div>
            
            <div x-show="showCourseModal" class="inline-block overflow-hidden text-left align-bottom transition-all transform glass-card rounded-3xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-white/10">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-white">Create New Class</h3>
                        <button @click="showCourseModal = false" class="text-zinc-500 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <form action="{{ route('teacher.courses.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="text-xs font-bold text-zinc-500 uppercase mb-2 block tracking-widest">Class Name</label>
                            <input type="text" name="name" required placeholder="e.g. Advanced Calculus" class="w-full bg-white/5 border-white/10 text-white rounded-xl px-4 py-3 outline-none focus:border-emerald-500/50">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-zinc-500 uppercase mb-2 block tracking-widest">Section</label>
                            <input type="text" name="section" required placeholder="e.g. Year 2 - Group B" class="w-full bg-white/5 border-white/10 text-white rounded-xl px-4 py-3 outline-none focus:border-emerald-500/50">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-zinc-500 uppercase mb-2 block tracking-widest">Description</label>
                            <textarea name="description" rows="3" placeholder="Brief overview of course objectives..." class="w-full bg-white/5 border-white/10 text-white rounded-xl px-4 py-3 outline-none focus:border-emerald-500/50"></textarea>
                        </div>
                        
                        <div class="pt-4 flex gap-3">
                            <button type="button" @click="showCourseModal = false" class="flex-1 py-3 bg-white/5 hover:bg-white/10 text-zinc-300 font-bold rounded-xl transition duration-200">Cancel</button>
                            <button type="submit" class="flex-1 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl transition duration-200 shadow-lg shadow-emerald-500/20">Create Class</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Prepare Chart Data
        const labels = {!! json_encode($performanceChartData['labels'] ?? []) !!};
        const data = {!! json_encode($performanceChartData['class_avg'] ?? []) !!};

        const ctx = document.getElementById('classTrendChart').getContext('2d');
        
        let gradient = ctx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.15)'); // blue-500
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Class Avg',
                    data: data,
                    borderColor: '#3b82f6', // blue-500
                    backgroundColor: gradient,
                    borderWidth: 1.5,
                    pointBackgroundColor: '#09090b',
                    pointBorderColor: '#3b82f6',
                    pointBorderWidth: 1.5,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    fill: true,
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuad'
                },
                layout: { padding: { top: 5, bottom: 5 } },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#18181b',
                        titleColor: '#f4f4f5',
                        bodyColor: '#a1a1aa',
                        borderColor: 'rgba(255,255,255,0.1)',
                        borderWidth: 1,
                        padding: { x: 8, y: 6 },
                        displayColors: false,
                        cornerRadius: 4,
                        titleFont: { size: 10, family: "'Inter', sans-serif" },
                        bodyFont: { size: 11, family: "'Inter', sans-serif", weight: 'bold' },
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        min: 60,
                        max: 100,
                        grid: { color: 'rgba(255, 255, 255, 0.03)', drawBorder: false },
                        border: { display: false },
                        ticks: { color: '#52525b', font: { size: 9, family: "'Inter', sans-serif" } }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        border: { display: false },
                        ticks: { color: '#52525b', font: { size: 9, family: "'Inter', sans-serif" } }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
            }
        });
    });
</script>
@endpush
