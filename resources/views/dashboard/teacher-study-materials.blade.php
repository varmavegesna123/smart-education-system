<x-teacher-layout>
<div class="space-y-6 pb-12">
    <div>
        <h2 class="text-2xl font-bold text-white tracking-tight">Study Materials</h2>
        <p class="text-zinc-500 text-sm">Upload and manage learning resources for your classes</p>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($materials->isEmpty())
        <div class="glass-card p-16 rounded-3xl text-center border border-white/5 flex flex-col items-center gap-4">
            <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <p class="text-white font-semibold">No Study Materials Uploaded</p>
            <p class="text-zinc-500 text-sm">Upload resources like PDFs, notes, or links for your students.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            @foreach($materials as $material)
            <div class="glass-card p-6 rounded-3xl border border-white/5 hover:border-white/10 transition-all duration-300 flex flex-col gap-4">
                <div class="flex items-start justify-between">
                    <div class="p-3 bg-blue-500/10 rounded-xl text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <span class="text-[10px] px-2.5 py-1 bg-white/5 border border-white/10 rounded-full font-bold uppercase text-zinc-400">{{ $material->type }}</span>
                </div>
                <div>
                    <h4 class="font-bold text-white text-base mb-1">{{ $material->title }}</h4>
                    <p class="text-xs text-zinc-500">{{ $material->classRoom?->name ?? '—' }} · {{ $material->subject?->name ?? '' }}</p>
                </div>
                <div class="text-xs text-zinc-600">Uploaded {{ $material->created_at->diffForHumans() }}</div>
            </div>
            @endforeach
        </div>
    @endif
</div>
</x-teacher-layout>
