<x-student-layout>
    <div class="py-8 space-y-8">
        
        @if(session('success'))
            <div class="p-4 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Enrolled Courses -->
        <div>
            <h2 class="text-xl font-bold text-white tracking-tight mb-4">My Courses</h2>
            @if($enrolledClasses->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($enrolledClasses as $class)
                        <div class="glass-card rounded-2xl p-6 border border-white/5 bg-white/[0.02] hover:border-white/10 transition group">
                            <div class="w-12 h-12 rounded-lg bg-gradient-to-tr from-blue-500/20 to-indigo-500/20 flex items-center justify-center mb-4 border border-blue-500/30">
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white mb-1">{{ $class->name }} - {{ $class->section }}</h3>
                            <p class="text-sm text-slate-400 mb-4">{{ $class->description }}</p>
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-slate-700 flex items-center justify-center text-[10px] font-bold text-white">
                                    {{ substr($class->teacher->user->name ?? 'T', 0, 1) }}
                                </div>
                                <span class="text-xs text-slate-400">{{ $class->teacher->user->name ?? 'Unknown Teacher' }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center border border-dashed border-white/10 rounded-2xl bg-white/[0.01]">
                    <p class="text-slate-400 text-sm">You are not enrolled in any courses yet.</p>
                </div>
            @endif
        </div>

        <!-- Pending Requests -->
        @if($pendingClasses->count() > 0)
        <div>
            <h2 class="text-lg font-semibold text-white tracking-tight mb-4">Pending Enrollment Requests</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($pendingClasses as $class)
                    <div class="glass-card rounded-2xl p-6 border border-amber-500/20 bg-amber-500/[0.02]">
                        <h3 class="text-base font-semibold text-white mb-1">{{ $class->name }} - {{ $class->section }}</h3>
                        <p class="text-xs text-slate-400 mb-4">Instructor: {{ $class->teacher->user->name ?? 'Unknown Teacher' }}</p>
                        <div class="inline-flex items-center gap-1.5 text-xs font-medium text-amber-500 bg-amber-500/10 px-2.5 py-1 rounded-full border border-amber-500/20">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                            Awaiting Approval
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Available Courses -->
        <div>
            <h2 class="text-xl font-bold text-white tracking-tight mb-4">Available Courses</h2>
            @if($availableClasses->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($availableClasses as $class)
                        <div class="glass-card rounded-2xl p-6 border border-white/5 bg-white/[0.02] flex flex-col h-full">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-white mb-1">{{ $class->name }} - {{ $class->section }}</h3>
                                <p class="text-sm text-slate-400 mb-4">{{ $class->description }}</p>
                                <div class="flex items-center gap-2 mb-6">
                                    <span class="text-xs text-slate-400">Teacher: {{ $class->teacher->user->name ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <form action="{{ route('student.enrollment.request') }}" method="POST" class="mt-auto">
                                @csrf
                                <input type="hidden" name="class_room_id" value="{{ $class->id }}">
                                <button type="submit" class="w-full bg-[#00D084] hover:bg-[#00a86b] text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                                    Send Request
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center border border-dashed border-white/10 rounded-2xl bg-white/[0.01]">
                    <p class="text-slate-400 text-sm">No new courses available to join at this moment.</p>
                </div>
            @endif
        </div>

    </div>
</x-student-layout>
