<x-student-layout>
<div class="space-y-6 pb-12">
    <div>
        <h2 class="text-2xl font-bold text-white tracking-tight">AI Insights</h2>
        <p class="text-zinc-500 text-sm">Personalized AI-powered learning recommendations</p>
    </div>

    @if($insights->isEmpty())
        <div class="glass-card p-16 rounded-3xl text-center border border-white/5 flex flex-col items-center gap-4">
            <div class="w-20 h-20 bg-gradient-to-br from-purple-500/20 to-blue-500/20 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
            </div>
            <p class="text-white font-semibold">No Insights Available</p>
            <p class="text-zinc-500 text-sm max-w-md">Once you have enough activity (attendance, assignments, assessments), our AI engine will generate personalized learning insights for you.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach($insights as $insight)
            @php
                $colors = [
                    'PerformancePrediction' => ['purple', 'bg-purple-500/10', 'border-purple-500/20', 'text-purple-400'],
                    'LearningPath' => ['blue', 'bg-blue-500/10', 'border-blue-500/20', 'text-blue-400'],
                    'CareerGuidance' => ['emerald', 'bg-emerald-500/10', 'border-emerald-500/20', 'text-emerald-400'],
                ];
                $c = $colors[$insight->type] ?? ['amber', 'bg-amber-500/10', 'border-amber-500/20', 'text-amber-400'];
            @endphp
            <div class="glass-card p-6 rounded-3xl border border-white/5 hover:border-white/10 transition-all duration-300">
                <div class="flex items-start gap-4">
                    <div class="p-3 {{ $c[1] }} rounded-xl {{ $c[3] }} flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[10px] font-bold uppercase tracking-widest {{ $c[3] }}">{{ str_replace(['_', 'Performance', 'Prediction', 'Learning', 'Path', 'Career', 'Guidance'], [' ', 'Performance', ' Prediction', 'Learning', ' Path', 'Career', ' Guidance'], $insight->type) }}</span>
                            <span class="text-xs font-bold text-zinc-500">{{ $insight->confidence_score }}% confidence</span>
                        </div>
                        <p class="text-sm text-zinc-300 leading-relaxed">{{ $insight->insight_text }}</p>
                        @if($insight->is_actionable)
                            <div class="mt-3 px-3 py-1.5 bg-white/5 border border-white/10 rounded-lg text-xs text-emerald-400 font-bold inline-block">
                                ✦ Actionable Insight
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
</x-student-layout>
