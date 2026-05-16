<x-teacher-layout>
    <div class="py-8">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Assessments</h1>
                <p class="text-slate-400 text-sm mt-1">Manage class tests, quizzes, and examinations.</p>
            </div>
            <button class="bg-[#00D084] hover:bg-[#00a86b] text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Create Assessment
            </button>
        </div>

        <div class="glass-card rounded-2xl p-12 text-center border border-white/5 bg-white/[0.02]">
            <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-[#00D084]/20 to-emerald-500/20 flex items-center justify-center mx-auto mb-6 border border-[#00D084]/30">
                <svg class="w-10 h-10 text-[#00D084]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">No Active Assessments</h3>
            <p class="text-slate-400 text-sm max-w-md mx-auto mb-6">There are no upcoming or past assessments for this class. Create a new assessment to start grading your students.</p>
        </div>
    </div>
</x-teacher-layout>
