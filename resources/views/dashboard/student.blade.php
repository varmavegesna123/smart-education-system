@extends('layouts.portal')

@section('title', 'Student Dashboard')
@section('header_title', 'Overview')

@section('sidebar_links')
    <a href="{{ route('student.dashboard') }}" class="nav-link active flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
        Dashboard
    </a>
    <a href="{{ route('student.courses') }}" class="nav-link flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium text-zinc-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
        Courses
    </a>
    <a href="{{ route('student.assignments') }}" class="nav-link flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium text-zinc-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
        Assignments
    </a>
    <a href="{{ route('student.attendance') }}" class="nav-link flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium text-zinc-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        Attendance
    </a>
    <a href="{{ route('student.insights') }}" class="nav-link flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium text-zinc-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
        Insights
    </a>
@endsection

@section('content')

    <!-- Hero / Welcome Banner -->
    <div class="relative overflow-hidden rounded-xl bg-zinc-900 border border-white/5 p-6 mb-6 group">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-[0.03]"></div>
        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-zinc-100 tracking-tight mb-1">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}</h2>
                <p class="text-xs text-zinc-400">You are on track. You have <span class="text-white font-medium">2 pending tasks</span> due this week.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('student.assignments') }}" class="px-3.5 py-1.5 bg-white hover:bg-zinc-200 text-zinc-900 text-xs font-semibold rounded-md transition-colors shadow-sm">View Tasks</a>
                <a href="{{ route('student.insights') }}" class="px-3.5 py-1.5 bg-zinc-800 hover:bg-zinc-700 text-zinc-200 border border-white/5 text-xs font-medium rounded-md transition-colors shadow-sm">AI Report</a>
            </div>
        </div>
    </div>

    <!-- KPIs -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Stat Card 1 -->
        <div class="premium-card rounded-xl p-4">
            <p class="text-[11px] font-medium text-zinc-500 uppercase tracking-wider mb-2">Mastery Score</p>
            <div class="flex items-end gap-2">
                <span class="text-2xl font-semibold text-zinc-100 tracking-tight leading-none">{{ $learningScore ?? 88 }}</span>
                <span class="text-[10px] text-emerald-500 font-medium mb-0.5 flex items-center">
                    <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    2%
                </span>
            </div>
            <div class="w-full bg-zinc-800 rounded-full h-1 mt-3 overflow-hidden">
                <div class="bg-emerald-500 h-1 rounded-full" style="width: {{ $learningScore ?? 88 }}%"></div>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="premium-card rounded-xl p-4">
            <p class="text-[11px] font-medium text-zinc-500 uppercase tracking-wider mb-2">Attendance</p>
            <div class="flex items-end gap-2">
                <span class="text-2xl font-semibold text-zinc-100 tracking-tight leading-none">{{ $attendancePercentage ?? 92 }}%</span>
                <span class="text-[10px] text-zinc-500 font-medium mb-0.5">This Month</span>
            </div>
            <div class="w-full bg-zinc-800 rounded-full h-1 mt-3 overflow-hidden">
                <div class="bg-blue-500 h-1 rounded-full" style="width: {{ $attendancePercentage ?? 92 }}%"></div>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="premium-card rounded-xl p-4">
            <p class="text-[11px] font-medium text-zinc-500 uppercase tracking-wider mb-2">Assignments</p>
            <div class="flex items-end gap-2">
                <span class="text-2xl font-semibold text-zinc-100 tracking-tight leading-none">2</span>
                <span class="text-[10px] text-amber-500 font-medium mb-0.5">Pending</span>
            </div>
            <div class="w-full bg-zinc-800 rounded-full h-1 mt-3 overflow-hidden">
                <div class="bg-amber-500 h-1 rounded-full w-2/5"></div>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="premium-card rounded-xl p-4">
            <p class="text-[11px] font-medium text-zinc-500 uppercase tracking-wider mb-2">Class Rank</p>
            <div class="flex items-end gap-2">
                <span class="text-2xl font-semibold text-zinc-100 tracking-tight leading-none">Top 15%</span>
            </div>
            <p class="text-[10px] text-zinc-400 mt-2.5 font-medium flex items-center">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                Excelling
            </p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Chart Section -->
        <div class="lg:col-span-2 premium-card rounded-xl p-5 flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-sm font-semibold text-zinc-100 tracking-tight">Performance Trend</h3>
                    <p class="text-[11px] text-zinc-500 mt-0.5">Scores across recent assessments</p>
                </div>
                <div class="flex gap-2">
                    <button class="px-2.5 py-1 text-[11px] font-medium bg-white/5 hover:bg-white/10 text-zinc-300 rounded border border-white/5 transition-colors">1M</button>
                    <button class="px-2.5 py-1 text-[11px] font-medium text-zinc-500 hover:text-zinc-300 transition-colors">3M</button>
                    <button class="px-2.5 py-1 text-[11px] font-medium text-zinc-500 hover:text-zinc-300 transition-colors">All</button>
                </div>
            </div>
            <div class="flex-1 min-h-[240px] relative w-full">
                <!-- Fallback Shimmer before JS loads -->
                <div id="chartSkeleton" class="absolute inset-0 shimmer rounded-lg opacity-20"></div>
                <canvas id="performanceChart" class="relative z-10"></canvas>
            </div>
        </div>

        <!-- AI Insights Sidebar -->
        <div class="premium-card rounded-xl flex flex-col">
            <div class="p-4 border-b border-white/5 flex items-center gap-2 bg-zinc-900/30">
                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                <h3 class="text-xs font-semibold text-zinc-100 uppercase tracking-wider">AI Insights</h3>
            </div>
            <div class="p-4 space-y-3 flex-1 overflow-y-auto">
                @if(isset($insights) && $insights->count() > 0)
                    @foreach($insights as $insight)
                        <div class="p-3 rounded-lg bg-zinc-900/50 border border-white/5 group hover:border-white/10 transition-colors">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-[10px] font-semibold tracking-wide uppercase {{ $insight['type'] == 'success' ? 'text-emerald-500' : 'text-amber-500' }}">
                                    {{ $insight['title'] }}
                                </span>
                                <span class="text-[10px] text-zinc-500">{{ $insight['confidence'] }}% Match</span>
                            </div>
                            <p class="text-xs text-zinc-300 leading-relaxed">{{ $insight['message'] }}</p>
                        </div>
                    @endforeach
                @else
                    <div class="p-3 rounded-lg bg-zinc-900/50 border border-white/5">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-[10px] font-semibold tracking-wide uppercase text-emerald-500">Pattern Detected</span>
                            <span class="text-[10px] text-zinc-500">92% Match</span>
                        </div>
                        <p class="text-xs text-zinc-300 leading-relaxed">Consistent high performance in Science subjects. Consider advanced coursework.</p>
                    </div>
                    <div class="p-3 rounded-lg bg-zinc-900/50 border border-white/5">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-[10px] font-semibold tracking-wide uppercase text-amber-500">Attention Needed</span>
                            <span class="text-[10px] text-zinc-500">85% Match</span>
                        </div>
                        <p class="text-xs text-zinc-300 leading-relaxed">Slight drop in Math scores compared to your historical average. Review Chapter 4.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Data Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        
        <!-- Pending Tasks Table (Linear Style) -->
        <div class="premium-card rounded-xl overflow-hidden flex flex-col">
            <div class="p-4 border-b border-white/5 flex justify-between items-center bg-zinc-900/30">
                <h3 class="text-xs font-semibold text-zinc-100 uppercase tracking-wider">Pending Tasks</h3>
                <a href="{{ route('student.assignments') }}" class="text-[10px] text-zinc-500 hover:text-zinc-300 font-medium">View All</a>
            </div>
            
            <div class="flex-1 divide-y divide-white/5">
                <!-- Task Row 1 -->
                <div class="flex items-center justify-between p-3 hover:bg-white/[0.02] transition-colors group cursor-pointer">
                    <div class="flex items-center gap-3">
                        <div class="w-4 h-4 rounded border border-zinc-600 flex items-center justify-center group-hover:border-emerald-500 transition-colors">
                            <svg class="w-2.5 h-2.5 text-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs text-zinc-200 font-medium group-hover:text-white transition-colors">Calculus Integration Set</p>
                            <p class="text-[10px] text-zinc-500">Mathematics</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-[10px] px-1.5 py-0.5 rounded bg-amber-500/10 text-amber-500 font-medium border border-amber-500/20">Tomorrow</span>
                    </div>
                </div>
                <!-- Task Row 2 -->
                <div class="flex items-center justify-between p-3 hover:bg-white/[0.02] transition-colors group cursor-pointer">
                    <div class="flex items-center gap-3">
                        <div class="w-4 h-4 rounded border border-zinc-600 flex items-center justify-center group-hover:border-emerald-500 transition-colors">
                            <svg class="w-2.5 h-2.5 text-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs text-zinc-200 font-medium group-hover:text-white transition-colors">Thermodynamics Lab Report</p>
                            <p class="text-[10px] text-zinc-500">Physics</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-[10px] text-zinc-500 font-medium">In 3 Days</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Scores Table -->
        <div class="premium-card rounded-xl overflow-hidden flex flex-col">
            <div class="p-4 border-b border-white/5 flex justify-between items-center bg-zinc-900/30">
                <h3 class="text-xs font-semibold text-zinc-100 uppercase tracking-wider">Recent Scores</h3>
                <a href="{{ route('student.assessments') }}" class="text-[10px] text-zinc-500 hover:text-zinc-300 font-medium">View Transcript</a>
            </div>
            
            <div class="flex-1">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/5 text-[10px] text-zinc-500 uppercase tracking-wider">
                            <th class="py-2.5 pl-4 font-medium">Assessment</th>
                            <th class="py-2.5 font-medium">Date</th>
                            <th class="py-2.5 pr-4 text-right font-medium">Score</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs">
                        <tr class="border-b border-white/5 hover:bg-white/[0.02] transition-colors">
                            <td class="py-2.5 pl-4 text-zinc-300 font-medium">Midterm Physics</td>
                            <td class="py-2.5 text-zinc-500">Oct 12</td>
                            <td class="py-2.5 pr-4 text-right"><span class="text-emerald-400 font-semibold tracking-tight">92%</span></td>
                        </tr>
                        <tr class="border-b border-white/5 hover:bg-white/[0.02] transition-colors">
                            <td class="py-2.5 pl-4 text-zinc-300 font-medium">Chemistry Quiz</td>
                            <td class="py-2.5 text-zinc-500">Oct 05</td>
                            <td class="py-2.5 pr-4 text-right"><span class="text-blue-400 font-semibold tracking-tight">78%</span></td>
                        </tr>
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="py-2.5 pl-4 text-zinc-300 font-medium">History Essay</td>
                            <td class="py-2.5 text-zinc-500">Sep 28</td>
                            <td class="py-2.5 pr-4 text-right"><span class="text-emerald-400 font-semibold tracking-tight">88%</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hide Skeleton once script runs
        const skeleton = document.getElementById('chartSkeleton');
        if (skeleton) skeleton.style.display = 'none';

        // Prepare Chart Data
        const labels = {!! json_encode($chartData['labels'] ?? ['W1', 'W2', 'W3', 'W4', 'W5', 'W6']) !!};
        const data = {!! json_encode($chartData['scores'] ?? [70, 72, 85, 82, 90, 88]) !!};

        const ctx = document.getElementById('performanceChart').getContext('2d');
        
        // Very subtle gradient
        let gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(16, 185, 129, 0.15)'); 
        gradient.addColorStop(1, 'rgba(16, 185, 129, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Score %',
                    data: data,
                    borderColor: '#10b981', // emerald-500
                    backgroundColor: gradient,
                    borderWidth: 1.5,
                    pointBackgroundColor: '#09090b',
                    pointBorderColor: '#10b981',
                    pointBorderWidth: 1.5,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    fill: true,
                    tension: 0.4, // Smooth Spline
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1200,
                    easing: 'easeOutExpo'
                },
                layout: {
                    padding: { top: 10 }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#18181b', // zinc-900
                        titleColor: '#f4f4f5',
                        bodyColor: '#a1a1aa',
                        borderColor: 'rgba(255,255,255,0.1)',
                        borderWidth: 1,
                        padding: { x: 10, y: 8 },
                        displayColors: false,
                        cornerRadius: 6,
                        titleFont: { size: 11, family: "'Inter', sans-serif" },
                        bodyFont: { size: 12, family: "'Inter', sans-serif", weight: 'bold' },
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: { color: 'rgba(255, 255, 255, 0.03)', drawBorder: false },
                        border: { display: false },
                        ticks: { color: '#52525b', font: { size: 10, family: "'Inter', sans-serif" }, padding: 8 }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        border: { display: false },
                        ticks: { color: '#52525b', font: { size: 10, family: "'Inter', sans-serif" }, padding: 8 }
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
