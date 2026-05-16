<x-teacher-layout>
<div class="space-y-6 pb-12">
    <div>
        <h2 class="text-2xl font-bold text-white tracking-tight">Class Analytics</h2>
        <p class="text-zinc-500 text-sm">AI-powered risk analysis and student performance overview</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="glass-card p-5 rounded-2xl border border-white/5">
            <p class="text-xs font-bold text-zinc-500 uppercase tracking-widest">Total Students</p>
            <span class="text-4xl font-black text-white mt-2 block">{{ $totalStudents }}</span>
        </div>
        <div class="glass-card p-5 rounded-2xl border border-white/5">
            <p class="text-xs font-bold text-zinc-500 uppercase tracking-widest">Safe</p>
            <span class="text-4xl font-black text-emerald-400 mt-2 block">{{ $riskCounts['Safe'] ?? 0 }}</span>
        </div>
        <div class="glass-card p-5 rounded-2xl border border-white/5">
            <p class="text-xs font-bold text-zinc-500 uppercase tracking-widest">Medium Risk</p>
            <span class="text-4xl font-black text-amber-400 mt-2 block">{{ $riskCounts['Medium Risk'] ?? 0 }}</span>
        </div>
        <div class="glass-card p-5 rounded-2xl border border-white/5 border-red-500/20 bg-red-500/5">
            <p class="text-xs font-bold text-red-400 uppercase tracking-widest">High Risk</p>
            <span class="text-4xl font-black text-red-400 mt-2 block">{{ $riskCounts['High Risk'] ?? 0 }}</span>
        </div>
    </div>

    <!-- Risk Distribution Chart -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-card p-8 rounded-3xl border border-white/5">
            <h4 class="font-bold text-white mb-6">Risk Distribution</h4>
            <div class="h-[280px]">
                <canvas id="riskChart"></canvas>
            </div>
        </div>

        <div class="glass-card p-8 rounded-3xl border border-white/5">
            <h4 class="font-bold text-white mb-6">Class Enrollment</h4>
            <div class="h-[280px]">
                <canvas id="enrollmentChart"></canvas>
            </div>
        </div>
    </div>

    <!-- At-Risk Students List -->
    @php
        $atRiskStudents = collect();
        foreach ($classRooms as $class) {
            foreach ($class->students->whereIn('risk_level', ['High Risk', 'Medium Risk']) as $s) {
                $atRiskStudents->push(['student' => $s, 'class' => $class->name]);
            }
        }
    @endphp

    @if($atRiskStudents->count() > 0)
    <div class="glass-card rounded-3xl overflow-hidden border border-white/5">
        <div class="p-6 border-b border-white/5 bg-white/[0.02]">
            <h4 class="font-bold text-white">⚠ Students Needing Attention</h4>
        </div>
        <div class="divide-y divide-white/5">
            @foreach($atRiskStudents->take(20) as $item)
            <div class="px-6 py-4 flex items-center justify-between hover:bg-white/[0.02] transition">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full {{ $item['student']->risk_level === 'High Risk' ? 'bg-red-500/20 text-red-400' : 'bg-amber-500/20 text-amber-400' }} flex items-center justify-center text-xs font-bold border border-white/10">
                        {{ strtoupper(substr($item['student']->user?->name ?? 'S', 0, 2)) }}
                    </div>
                    <div>
                        <div class="font-medium text-white">{{ $item['student']->user?->name ?? 'Unknown' }}</div>
                        <div class="text-xs text-zinc-500">{{ $item['class'] }}</div>
                    </div>
                </div>
                <span class="text-[10px] font-bold uppercase px-3 py-1 rounded-full border
                    {{ $item['student']->risk_level === 'High Risk' ? 'bg-red-500/10 text-red-400 border-red-500/20' : 'bg-amber-500/10 text-amber-400 border-amber-500/20' }}">
                    {{ $item['student']->risk_level }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Risk Chart
    new Chart(document.getElementById('riskChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Safe', 'Medium Risk', 'High Risk'],
            datasets: [{
                data: [{{ $riskCounts['Safe'] ?? 0 }}, {{ $riskCounts['Medium Risk'] ?? 0 }}, {{ $riskCounts['High Risk'] ?? 0 }}],
                backgroundColor: ['rgba(16, 185, 129, 0.7)', 'rgba(245, 158, 11, 0.7)', 'rgba(239, 68, 68, 0.7)'],
                borderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: { position: 'bottom', labels: { color: 'rgba(255,255,255,0.6)', usePointStyle: true, padding: 20, font: { size: 12, weight: 'bold' } } }
            }
        }
    });

    // Enrollment Chart
    new Chart(document.getElementById('enrollmentChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($classRooms->pluck('name')->map(fn($n, $i) => $n . ' ' . $classRooms->values()[$i]->section)->toArray()) !!},
            datasets: [{
                label: 'Enrolled',
                data: {!! json_encode($classRooms->map(fn($c) => $c->students->count())->toArray()) !!},
                backgroundColor: 'rgba(16, 185, 129, 0.6)',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            scales: {
                x: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: 'rgba(255,255,255,0.4)' } },
                y: { grid: { display: false }, ticks: { color: 'rgba(255,255,255,0.6)', font: { weight: 'bold' } } }
            },
            plugins: { legend: { display: false } }
        }
    });
});
</script>
</x-teacher-layout>
