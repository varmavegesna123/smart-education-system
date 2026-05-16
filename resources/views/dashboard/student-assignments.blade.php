<x-student-layout>
<div class="space-y-6 pb-12">

    <!-- Header -->
    <div>
        <h2 class="text-2xl font-bold text-white tracking-tight">My Assignments</h2>
        <p class="text-zinc-500 text-sm">View and submit assignments from your enrolled courses</p>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($assignments->isEmpty())
        <div class="glass-card p-16 rounded-3xl text-center border border-white/5 flex flex-col items-center gap-4">
            <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div>
                <p class="text-white font-semibold">No Assignments Yet</p>
                <p class="text-zinc-500 text-sm mt-1">You'll see assignments here once you enroll in a course and your teacher publishes one.</p>
            </div>
            <a href="{{ route('student.courses') }}" class="px-5 py-2.5 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded-xl text-sm font-bold hover:bg-emerald-500/20 transition">Browse Courses →</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            @foreach($assignments as $assignment)
            @php
                $submission = $assignment->submissions->first();
                $isPast = $assignment->due_date->isPast();
                $statusLabel = 'Pending';
                $statusClass = 'bg-amber-500/10 text-amber-400 border-amber-500/20';
                if ($submission) {
                    if ($submission->status === 'reviewed') {
                        $statusLabel = 'Graded';
                        $statusClass = 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20';
                    } else {
                        $statusLabel = 'Submitted';
                        $statusClass = 'bg-blue-500/10 text-blue-400 border-blue-500/20';
                    }
                } elseif ($isPast) {
                    $statusLabel = 'Late';
                    $statusClass = 'bg-red-500/10 text-red-400 border-red-500/20';
                }
            @endphp
            <div class="glass-card rounded-3xl border border-white/5 hover:border-white/10 transition-all duration-300 flex flex-col overflow-hidden" x-data="{ open: false }">
                <div class="p-6 flex flex-col gap-4 flex-1">
                    <div class="flex items-start justify-between">
                        <div class="p-3 bg-blue-500/10 rounded-xl text-blue-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <span class="text-[10px] px-2.5 py-1 rounded-full font-bold uppercase border {{ $statusClass }}">{{ $statusLabel }}</span>
                    </div>

                    <div>
                        <h4 class="font-bold text-white text-base mb-1">{{ $assignment->title }}</h4>
                        <p class="text-xs text-zinc-500 line-clamp-2">{{ $assignment->description }}</p>
                    </div>

                    <div class="grid grid-cols-3 gap-3 text-center">
                        <div class="bg-white/5 rounded-xl p-2">
                            <p class="text-xs text-zinc-500 mb-0.5">Course</p>
                            <p class="text-xs font-bold text-white truncate">{{ $assignment->classRoom->name }}</p>
                        </div>
                        <div class="bg-white/5 rounded-xl p-2">
                            <p class="text-xs text-zinc-500 mb-0.5">Marks</p>
                            <p class="text-sm font-bold text-white">{{ $submission?->marks_awarded ?? '—' }}/{{ $assignment->total_marks }}</p>
                        </div>
                        <div class="bg-white/5 rounded-xl p-2">
                            <p class="text-xs text-zinc-500 mb-0.5">Due</p>
                            <p class="text-xs font-bold {{ $isPast ? 'text-red-400' : 'text-white' }}">{{ $assignment->due_date->format('d M') }}</p>
                        </div>
                    </div>

                    @if($submission?->teacher_feedback)
                        <div class="bg-emerald-500/5 border border-emerald-500/20 rounded-xl p-3 text-xs text-emerald-300">
                            <p class="font-bold text-emerald-400 mb-1">Teacher Feedback:</p>
                            {{ $submission->teacher_feedback }}
                        </div>
                    @endif
                </div>

                <!-- Submission Section -->
                @if(!$submission || $submission->status === 'pending')
                <div class="border-t border-white/5 p-6 bg-white/[0.02]">
                    <button @click="open = !open" class="w-full py-2.5 text-sm font-bold rounded-xl transition-all duration-200 flex items-center justify-center gap-2
                        @if($isPast) bg-red-500/10 text-red-400 hover:bg-red-500/20 @else bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 @endif">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        {{ $isPast ? 'Submit Late' : 'Submit Work' }}
                    </button>
                    <div x-show="open" x-transition class="mt-4">
                        <form action="{{ route('student.assignments.submit', $assignment->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <textarea name="student_comment" rows="2" placeholder="Add a note (optional)..." class="w-full bg-white/5 border border-white/10 text-white text-sm rounded-xl px-4 py-3 outline-none focus:border-emerald-500/50"></textarea>
                            <input type="file" name="file" required accept=".pdf,.doc,.docx,.zip" class="w-full text-zinc-400 text-xs file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-white/10 file:text-zinc-300">
                            <button type="submit" class="w-full py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-bold rounded-xl transition duration-200">Upload & Submit</button>
                        </form>
                    </div>
                </div>
                @elseif($submission?->status === 'submitted')
                    <div class="border-t border-white/5 p-4 text-center">
                        <span class="text-xs text-blue-400">✓ Submitted {{ $submission->submitted_at?->diffForHumans() }}. Awaiting review.</span>
                    </div>
                @endif
            </div>
            @endforeach
        </div>
    @endif

</div>
</x-student-layout>
