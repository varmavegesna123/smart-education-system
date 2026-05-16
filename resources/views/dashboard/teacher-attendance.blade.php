<x-teacher-layout>
<div class="space-y-6 pb-12">

    <!-- Header -->
    <div>
        <h2 class="text-2xl font-bold text-white tracking-tight">Mark Attendance</h2>
        <p class="text-zinc-500 text-sm">Select a class and date to record attendance</p>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($classRooms->isEmpty())
        <div class="glass-card p-16 rounded-3xl text-center border border-white/5">
            <p class="text-zinc-500">You have no classes. Create one from your dashboard first.</p>
        </div>
    @else
        <!-- Filters -->
        <form method="GET" action="{{ route('teacher.attendance') }}" class="glass-card p-6 rounded-3xl border border-white/5">
            <div class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label class="text-xs font-bold text-zinc-500 uppercase mb-2 block tracking-widest">Select Class</label>
                    <select name="class_room_id" onchange="this.form.submit()" class="w-full bg-[#111] border border-white/10 text-white rounded-xl px-4 py-3 outline-none focus:border-emerald-500/50">
                        @foreach($classRooms as $class)
                            <option value="{{ $class->id }}" @selected($class->id == $selectedClass?->id)>{{ $class->name }} – {{ $class->section }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="text-xs font-bold text-zinc-500 uppercase mb-2 block tracking-widest">Date</label>
                    <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()" class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-3 outline-none focus:border-emerald-500/50">
                </div>
            </div>
        </form>

        <!-- Attendance Form -->
        @if($selectedClass)
        <form method="POST" action="{{ route('teacher.attendance.store') }}">
            @csrf
            <input type="hidden" name="class_room_id" value="{{ $selectedClass->id }}">
            <input type="hidden" name="date" value="{{ $date }}">

            <div class="glass-card rounded-3xl overflow-hidden border border-white/5">
                <div class="p-6 border-b border-white/5 flex items-center justify-between bg-white/[0.02]">
                    <div>
                        <h4 class="font-bold text-white">{{ $selectedClass->name }}</h4>
                        <p class="text-xs text-zinc-500">{{ \Carbon\Carbon::parse($date)->format('l, d F Y') }}</p>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" onclick="markAll('present')" class="px-4 py-2 text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded-xl hover:bg-emerald-500/20 transition">✓ All Present</button>
                        <button type="button" onclick="markAll('absent')" class="px-4 py-2 text-xs font-bold bg-red-500/10 text-red-400 border border-red-500/20 rounded-xl hover:bg-red-500/20 transition">✗ All Absent</button>
                    </div>
                </div>

                <div class="divide-y divide-white/5">
                    @forelse($selectedClass->students as $student)
                    @php $status = $existing->get($student->id, 'present'); @endphp
                    <div class="flex items-center justify-between px-6 py-4 hover:bg-white/[0.02] transition">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500/30 to-blue-500/30 flex items-center justify-center text-sm font-bold text-white border border-white/10">
                                {{ strtoupper(substr($student->user?->name ?? 'S', 0, 2)) }}
                            </div>
                            <div>
                                <div class="font-medium text-white">{{ $student->user?->name ?? 'Unknown' }}</div>
                                <div class="text-xs text-zinc-500">{{ $student->enrollment_number }}</div>
                            </div>
                        </div>

                        <div class="flex gap-2" id="btn-group-{{ $student->id }}">
                            @foreach(['present' => ['emerald', '✓ Present'], 'absent' => ['red', '✗ Absent'], 'late' => ['amber', '⚬ Late']] as $val => [$color, $label])
                            <label class="cursor-pointer">
                                <input type="radio" name="attendance[{{ $student->id }}]" value="{{ $val }}" class="peer sr-only" {{ $status === $val ? 'checked' : '' }} data-student="{{ $student->id }}">
                                <span class="peer-checked:bg-{{ $color }}-500/20 peer-checked:text-{{ $color }}-400 peer-checked:border-{{ $color }}-500/40 px-4 py-2 rounded-xl text-xs font-bold border border-white/10 text-zinc-500 hover:text-zinc-300 hover:bg-white/5 transition-all duration-150 block">{{ $label }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @empty
                        <div class="px-6 py-12 text-center text-zinc-500">No students enrolled in this class yet.</div>
                    @endforelse
                </div>

                <div class="p-6 border-t border-white/5 bg-white/[0.02]">
                    <button type="submit" class="w-full py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl transition duration-200 shadow-lg shadow-emerald-500/20">
                        Save Attendance for {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                    </button>
                </div>
            </div>
        </form>

        <!-- Recent Sessions -->
        @if($sessions->count() > 0)
        <div class="glass-card rounded-3xl overflow-hidden border border-white/5">
            <div class="p-6 border-b border-white/5">
                <h4 class="font-bold text-white">Recent Sessions – {{ $selectedClass->name }}</h4>
            </div>
            <div class="divide-y divide-white/5">
                @foreach($sessions as $session)
                @php
                    $total = $session->attendances->count();
                    $presentCount = $session->attendances->where('status', 'present')->count();
                    $pct = $total > 0 ? round($presentCount / $total * 100) : 0;
                @endphp
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <div class="text-sm font-medium text-white">{{ \Carbon\Carbon::parse($session->date)->format('l, d M Y') }}</div>
                        <div class="text-xs text-zinc-500">{{ $total }} students recorded</div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-32 bg-white/5 rounded-full h-1.5">
                            <div class="h-1.5 rounded-full {{ $pct >= 80 ? 'bg-emerald-500' : ($pct >= 60 ? 'bg-amber-500' : 'bg-red-500') }}" style="width: {{ $pct }}%"></div>
                        </div>
                        <span class="text-sm font-bold {{ $pct >= 80 ? 'text-emerald-400' : ($pct >= 60 ? 'text-amber-400' : 'text-red-400') }}">{{ $pct }}%</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @endif
    @endif
</div>

<script>
function markAll(status) {
    document.querySelectorAll(`input[type=radio][value="${status}"]`).forEach(r => r.checked = true);
}
</script>
</x-teacher-layout>
