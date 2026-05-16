<x-student-layout>
<div class="space-y-6 pb-12">
    <div>
        <h2 class="text-2xl font-bold text-white tracking-tight">Remedial Tasks</h2>
        <p class="text-zinc-500 text-sm">AI-recommended tasks to improve your weak areas</p>
    </div>

    @if($tasks->isEmpty())
        <div class="glass-card p-16 rounded-3xl text-center border border-white/5 flex flex-col items-center gap-4">
            <div class="w-20 h-20 bg-emerald-500/10 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-white font-semibold">All Clear!</p>
            <p class="text-zinc-500 text-sm">No remedial tasks assigned. Keep up the excellent work!</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach($tasks as $task)
            @php
                $isPending = $task->status === 'pending';
                $isOverdue = $task->due_date?->isPast() && $isPending;
            @endphp
            <div class="glass-card rounded-3xl border {{ $isOverdue ? 'border-red-500/20' : 'border-white/5' }} overflow-hidden hover:border-white/10 transition-all duration-300">
                <div class="p-6 flex flex-col gap-4">
                    <div class="flex items-start justify-between">
                        <div class="p-3 {{ $isPending ? 'bg-amber-500/10 text-amber-400' : 'bg-emerald-500/10 text-emerald-400' }} rounded-xl flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <span class="text-[10px] px-2.5 py-1 rounded-full font-bold uppercase border
                            @if($isOverdue) bg-red-500/10 text-red-400 border-red-500/20
                            @elseif($isPending) bg-amber-500/10 text-amber-400 border-amber-500/20
                            @else bg-emerald-500/10 text-emerald-400 border-emerald-500/20
                            @endif">
                            {{ $isOverdue ? 'Overdue' : ucfirst($task->status) }}
                        </span>
                    </div>

                    <div>
                        <h4 class="font-bold text-white text-base mb-1">{{ $task->title }}</h4>
                        <p class="text-xs text-zinc-500 leading-relaxed">{{ $task->description }}</p>
                    </div>

                    <div class="grid grid-cols-3 gap-3 text-center">
                        <div class="bg-white/5 rounded-xl p-2">
                            <p class="text-xs text-zinc-500 mb-0.5">Subject</p>
                            <p class="text-xs font-bold text-white truncate">{{ $task->subject?->name ?? '—' }}</p>
                        </div>
                        <div class="bg-white/5 rounded-xl p-2">
                            <p class="text-xs text-zinc-500 mb-0.5">Teacher</p>
                            <p class="text-xs font-bold text-white truncate">{{ $task->teacher?->user?->name ?? '—' }}</p>
                        </div>
                        <div class="bg-white/5 rounded-xl p-2">
                            <p class="text-xs text-zinc-500 mb-0.5">Due</p>
                            <p class="text-xs font-bold {{ $isOverdue ? 'text-red-400' : 'text-white' }}">{{ $task->due_date?->format('d M') ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
</x-student-layout>
