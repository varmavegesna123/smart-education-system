<x-student-layout>
<div class="space-y-6 pb-12">

    <!-- Header -->
    <div>
        <h2 class="text-2xl font-bold text-white tracking-tight">My Attendance</h2>
        <p class="text-zinc-500 text-sm">Track your class presence and attendance percentage</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="glass-card p-5 rounded-2xl border border-white/5 flex flex-col gap-2">
            <p class="text-xs font-bold text-zinc-500 uppercase tracking-widest">Attendance</p>
            <div class="flex items-end gap-2">
                <span class="text-4xl font-black {{ $percentage >= 75 ? 'text-emerald-400' : 'text-red-400' }}">{{ $percentage }}%</span>
            </div>
            @if($percentage < 75)
                <p class="text-xs text-red-400 font-semibold">⚠ Below 75% threshold</p>
            @else
                <p class="text-xs text-emerald-400">Good standing</p>
            @endif
        </div>
        <div class="glass-card p-5 rounded-2xl border border-white/5 flex flex-col gap-2">
            <p class="text-xs font-bold text-zinc-500 uppercase tracking-widest">Total Days</p>
            <span class="text-4xl font-black text-white">{{ $total }}</span>
        </div>
        <div class="glass-card p-5 rounded-2xl border border-white/5 flex flex-col gap-2">
            <p class="text-xs font-bold text-zinc-500 uppercase tracking-widest">Present</p>
            <span class="text-4xl font-black text-emerald-400">{{ $present }}</span>
        </div>
        <div class="glass-card p-5 rounded-2xl border border-white/5 flex flex-col gap-2">
            <p class="text-xs font-bold text-zinc-500 uppercase tracking-widest">Absent / Late</p>
            <span class="text-4xl font-black text-red-400">{{ $absent + $late }}</span>
        </div>
    </div>

    @if($percentage < 75 && $total > 0)
    <div class="p-5 rounded-2xl bg-red-500/10 border border-red-500/20 flex items-start gap-4">
        <div class="p-2.5 bg-red-500/20 rounded-xl text-red-400 mt-0.5 flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <div>
            <p class="font-bold text-red-400 text-sm">Low Attendance Warning</p>
            <p class="text-red-300/70 text-xs mt-1">Your attendance has dropped below 75%. This may affect your eligibility for exams. Please contact your teacher.</p>
        </div>
    </div>
    @endif

    <!-- Attendance Records -->
    @if($records->isEmpty())
        <div class="glass-card p-16 rounded-3xl text-center border border-white/5">
            <p class="text-zinc-500">No attendance records found yet. Attend classes to see your history here.</p>
        </div>
    @else
        <div class="glass-card rounded-3xl overflow-hidden border border-white/5">
            <div class="p-6 border-b border-white/5 bg-white/[0.02]">
                <h4 class="font-bold text-white">Attendance History</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-gray-300">
                    <thead class="bg-white/[0.03] text-xs uppercase tracking-widest font-bold">
                        <tr>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Course</th>
                            <th class="px-6 py-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($records as $record)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="px-6 py-4 text-sm text-zinc-300">{{ $record->date->format('l, d M Y') }}</td>
                            <td class="px-6 py-4 text-sm">{{ $record->classRoom->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-[10px] font-bold uppercase px-3 py-1 rounded-full border
                                    @if($record->status === 'present') bg-emerald-500/10 text-emerald-400 border-emerald-500/20
                                    @elseif($record->status === 'absent') bg-red-500/10 text-red-400 border-red-500/20
                                    @else bg-amber-500/10 text-amber-400 border-amber-500/20
                                    @endif">
                                    {{ ucfirst($record->status) }}
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
</x-student-layout>
