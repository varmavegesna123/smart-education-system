<x-student-layout>
<div class="space-y-6 pb-12">
    <div>
        <h2 class="text-2xl font-bold text-white tracking-tight">Performance Report</h2>
        <p class="text-zinc-500 text-sm">Comprehensive overview of your academic performance</p>
    </div>

    <!-- KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="glass-card p-6 rounded-2xl border border-white/5">
            <p class="text-xs font-bold text-zinc-500 uppercase tracking-widest mb-3">Attendance Rate</p>
            <div class="flex items-end gap-3">
                <span class="text-5xl font-black {{ $attendancePct >= 75 ? 'text-emerald-400' : 'text-red-400' }}">{{ $attendancePct }}%</span>
            </div>
            <div class="mt-3 w-full bg-white/5 rounded-full h-2">
                <div class="h-2 rounded-full {{ $attendancePct >= 75 ? 'bg-emerald-500' : 'bg-red-500' }}" style="width: {{ $attendancePct }}%"></div>
            </div>
        </div>
        <div class="glass-card p-6 rounded-2xl border border-white/5">
            <p class="text-xs font-bold text-zinc-500 uppercase tracking-widest mb-3">Average Score</p>
            <div class="flex items-end gap-3">
                <span class="text-5xl font-black text-white">{{ $avgMarks }}</span>
                <span class="text-zinc-500 text-lg mb-1">/100</span>
            </div>
            <div class="mt-3 w-full bg-white/5 rounded-full h-2">
                <div class="h-2 rounded-full bg-blue-500" style="width: {{ $avgMarks }}%"></div>
            </div>
        </div>
        <div class="glass-card p-6 rounded-2xl border border-white/5">
            <p class="text-xs font-bold text-zinc-500 uppercase tracking-widest mb-3">Submission Rate</p>
            <div class="flex items-end gap-3">
                <span class="text-5xl font-black text-purple-400">{{ $submissionRate }}%</span>
            </div>
            <div class="mt-3 w-full bg-white/5 rounded-full h-2">
                <div class="h-2 rounded-full bg-purple-500" style="width: {{ $submissionRate }}%"></div>
            </div>
        </div>
    </div>

    <!-- Score Chart -->
    <div class="glass-card p-8 rounded-3xl border border-white/5">
        <h4 class="font-bold text-white mb-6">Score Distribution</h4>
        <div class="h-[300px]">
            <canvas id="scoreChart"></canvas>
        </div>
    </div>

    <!-- Assessment Breakdown -->
    @if($marks->count() > 0)
    <div class="glass-card rounded-3xl overflow-hidden border border-white/5">
        <div class="p-6 border-b border-white/5 bg-white/[0.02]">
            <h4 class="font-bold text-white">Detailed Score History</h4>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-gray-300">
                <thead class="bg-white/[0.03] text-xs uppercase tracking-widest font-bold">
                    <tr>
                        <th class="px-6 py-4">Assessment</th>
                        <th class="px-6 py-4">Subject</th>
                        <th class="px-6 py-4 text-center">Score</th>
                        <th class="px-6 py-4 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($marks as $mark)
                    @php
                        $pct = $mark->assessment?->total_marks > 0 ? round(($mark->marks_obtained / $mark->assessment->total_marks) * 100) : 0;
                    @endphp
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-4 font-medium text-white">{{ $mark->assessment?->title ?? 'Unknown' }}</td>
                        <td class="px-6 py-4 text-sm text-zinc-500">{{ $mark->assessment?->subject?->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-bold text-white">{{ $mark->marks_obtained }}</span>
                            <span class="text-zinc-500">/{{ $mark->assessment?->total_marks }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-[10px] font-bold uppercase px-3 py-1 rounded-full border
                                @if($pct >= 70) bg-emerald-500/10 text-emerald-400 border-emerald-500/20
                                @elseif($pct >= 50) bg-amber-500/10 text-amber-400 border-amber-500/20
                                @else bg-red-500/10 text-red-400 border-red-500/20
                                @endif">
                                {{ $pct >= 70 ? 'Pass' : ($pct >= 50 ? 'Average' : 'Needs Work') }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const labels = {!! json_encode($marks->pluck('assessment.title')->map(fn($t) => $t ?? 'Unknown')->toArray()) !!};
    const scores = {!! json_encode($marks->pluck('marks_obtained')->toArray()) !!};

    let gradient = document.getElementById('scoreChart').getContext('2d').createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(16, 185, 129, 0.4)');
    gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

    new Chart(document.getElementById('scoreChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Score',
                data: scores,
                borderColor: '#10b981',
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 5,
                pointBackgroundColor: '#10b981'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { grid: { display: false }, ticks: { color: 'rgba(255,255,255,0.4)', font: { size: 10 } } },
                y: { beginAtZero: true, max: 100, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: 'rgba(255,255,255,0.4)' } }
            },
            plugins: {
                legend: { display: false },
                tooltip: { backgroundColor: '#1a1a1a', titleColor: '#fff', bodyColor: '#ccc', borderColor: 'rgba(255,255,255,0.1)', borderWidth: 1, padding: 12, displayColors: false }
            }
        }
    });
});
</script>
</x-student-layout>
