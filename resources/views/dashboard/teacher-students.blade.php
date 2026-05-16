<x-teacher-layout>
<div class="space-y-6 pb-12">
    <div>
        <h2 class="text-2xl font-bold text-white tracking-tight">Student Roster</h2>
        <p class="text-zinc-500 text-sm">View enrolled students across all your classes</p>
    </div>

    @if($classRooms->isEmpty())
        <div class="glass-card p-16 rounded-3xl text-center border border-white/5">
            <p class="text-zinc-500">You don't have any classes yet. Create one from your dashboard.</p>
        </div>
    @else
        @foreach($classRooms as $class)
        <div class="glass-card rounded-3xl overflow-hidden border border-white/5">
            <div class="p-6 border-b border-white/5 bg-white/[0.02] flex justify-between items-center">
                <div>
                    <h4 class="font-bold text-white text-lg">{{ $class->name }} — {{ $class->section }}</h4>
                    <p class="text-xs text-zinc-500 mt-0.5">{{ $class->students->count() }} enrolled students</p>
                </div>
                <div class="flex items-center gap-2">
                    @php
                        $safeCount = $class->students->where('risk_level', 'Safe')->count();
                        $medCount = $class->students->where('risk_level', 'Medium Risk')->count();
                        $highCount = $class->students->where('risk_level', 'High Risk')->count();
                    @endphp
                    <span class="px-2.5 py-1 bg-emerald-500/10 text-emerald-400 text-[10px] font-bold rounded-full border border-emerald-500/20">{{ $safeCount }} Safe</span>
                    <span class="px-2.5 py-1 bg-amber-500/10 text-amber-400 text-[10px] font-bold rounded-full border border-amber-500/20">{{ $medCount }} Medium</span>
                    <span class="px-2.5 py-1 bg-red-500/10 text-red-400 text-[10px] font-bold rounded-full border border-red-500/20">{{ $highCount }} High</span>
                </div>
            </div>

            @if($class->students->isEmpty())
                <div class="p-8 text-center text-zinc-500">No students enrolled yet.</div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-gray-300">
                        <thead class="bg-white/[0.03] text-xs uppercase tracking-widest font-bold">
                            <tr>
                                <th class="px-6 py-3">Student</th>
                                <th class="px-6 py-3">Enrollment #</th>
                                <th class="px-6 py-3 text-center">Risk Level</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($class->students as $student)
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-emerald-500/30 to-blue-500/30 flex items-center justify-center text-xs font-bold text-white border border-white/10">
                                            {{ strtoupper(substr($student->user?->name ?? 'S', 0, 2)) }}
                                        </div>
                                        <span class="font-medium text-white">{{ $student->user?->name ?? 'Unknown' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-500">{{ $student->enrollment_number }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-[10px] font-bold uppercase px-3 py-1 rounded-full border
                                        @if($student->risk_level === 'High Risk') bg-red-500/10 text-red-400 border-red-500/20
                                        @elseif($student->risk_level === 'Medium Risk') bg-amber-500/10 text-amber-400 border-amber-500/20
                                        @else bg-emerald-500/10 text-emerald-400 border-emerald-500/20
                                        @endif">
                                        {{ $student->risk_level }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        @endforeach
    @endif
</div>
</x-teacher-layout>
