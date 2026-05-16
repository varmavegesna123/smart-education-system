<x-student-layout>
<div class="space-y-6 pb-12">
    <div>
        <h2 class="text-2xl font-bold text-white tracking-tight">Assessment Results</h2>
        <p class="text-zinc-500 text-sm">View your exam and quiz scores across subjects</p>
    </div>

    @if($marks->isEmpty())
        <div class="glass-card p-16 rounded-3xl text-center border border-white/5 flex flex-col items-center gap-4">
            <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            </div>
            <p class="text-white font-semibold">No Assessment Records</p>
            <p class="text-zinc-500 text-sm">Your scores will appear here after assessments are graded.</p>
        </div>
    @else
        <!-- Summary -->
        @php
            $avgScore = $marks->avg('marks_obtained');
            $highest = $marks->max('marks_obtained');
            $lowest = $marks->min('marks_obtained');
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="glass-card p-5 rounded-2xl border border-white/5">
                <p class="text-xs font-bold text-zinc-500 uppercase tracking-widest">Average Score</p>
                <span class="text-4xl font-black text-white mt-2 block">{{ round($avgScore) }}%</span>
            </div>
            <div class="glass-card p-5 rounded-2xl border border-white/5">
                <p class="text-xs font-bold text-zinc-500 uppercase tracking-widest">Highest</p>
                <span class="text-4xl font-black text-emerald-400 mt-2 block">{{ $highest }}</span>
            </div>
            <div class="glass-card p-5 rounded-2xl border border-white/5">
                <p class="text-xs font-bold text-zinc-500 uppercase tracking-widest">Lowest</p>
                <span class="text-4xl font-black text-red-400 mt-2 block">{{ $lowest }}</span>
            </div>
        </div>

        <!-- Marks Table -->
        <div class="glass-card rounded-3xl overflow-hidden border border-white/5">
            <div class="p-6 border-b border-white/5 bg-white/[0.02]">
                <h4 class="font-bold text-white">Score Breakdown</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-gray-300">
                    <thead class="bg-white/[0.03] text-xs uppercase tracking-widest font-bold">
                        <tr>
                            <th class="px-6 py-4">Assessment</th>
                            <th class="px-6 py-4">Subject</th>
                            <th class="px-6 py-4">Class</th>
                            <th class="px-6 py-4 text-center">Score</th>
                            <th class="px-6 py-4 text-right">Grade</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($marks as $mark)
                        @php
                            $pct = $mark->assessment?->total_marks > 0 ? round(($mark->marks_obtained / $mark->assessment->total_marks) * 100) : 0;
                            $grade = $pct >= 90 ? 'A+' : ($pct >= 80 ? 'A' : ($pct >= 70 ? 'B' : ($pct >= 60 ? 'C' : ($pct >= 50 ? 'D' : 'F'))));
                            $gradeColor = $pct >= 70 ? 'text-emerald-400' : ($pct >= 50 ? 'text-amber-400' : 'text-red-400');
                        @endphp
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium text-white">{{ $mark->assessment?->title ?? 'Unknown' }}</div>
                                <div class="text-xs text-zinc-500">{{ $mark->assessment?->type ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm">{{ $mark->assessment?->subject?->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-zinc-500">{{ $mark->assessment?->classRoom?->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="font-bold text-white">{{ $mark->marks_obtained }}</span>
                                <span class="text-zinc-500">/{{ $mark->assessment?->total_marks }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-sm font-bold {{ $gradeColor }}">{{ $grade }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
</x-student-layout>
