<x-teacher-layout>
<div x-data="{ activeTab: 'list', showModal: false, selectedSubmission: null }" class="space-y-6 pb-12">

    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">Assignments</h2>
            <p class="text-zinc-500 text-sm">Create, review, and grade student submissions</p>
        </div>
        <button @click="showModal = true" class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-sm font-bold transition duration-200 shadow-lg shadow-emerald-500/20 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Assignment
        </button>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabs -->
    <div class="flex p-1 bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl w-fit">
        <button @click="activeTab = 'list'" :class="activeTab === 'list' ? 'bg-white/10 text-white shadow-lg' : 'text-gray-400 hover:text-white'" class="px-6 py-2.5 rounded-xl text-sm font-medium transition-all duration-200">
            Published ({{ $assignments->count() }})
        </button>
        <button @click="activeTab = 'submissions'" :class="activeTab === 'submissions' ? 'bg-white/10 text-white shadow-lg' : 'text-gray-400 hover:text-white'" class="px-6 py-2.5 rounded-xl text-sm font-medium transition-all duration-200">
            Pending Review ({{ $submissions->count() }})
        </button>
    </div>

    <!-- Assignment List Tab -->
    <div x-show="activeTab === 'list'">
        @if($assignments->isEmpty())
            <div class="glass-card p-16 rounded-3xl text-center border border-white/5">
                <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <p class="text-zinc-500">No assignments created yet. Click "New Assignment" to get started.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                @foreach($assignments as $assignment)
                <div class="glass-card p-6 rounded-3xl border border-white/5 hover:border-white/10 transition-all duration-300 flex flex-col gap-4">
                    <div class="flex items-start justify-between">
                        <div class="p-3 bg-blue-500/10 rounded-xl text-blue-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <span class="text-[10px] px-2.5 py-1 rounded-full font-bold uppercase tracking-wide
                            @if($assignment->due_date->isPast()) bg-red-500/10 text-red-400 border border-red-500/20
                            @elseif($assignment->due_date->diffInDays(now()) <= 3) bg-amber-500/10 text-amber-400 border border-amber-500/20
                            @else bg-emerald-500/10 text-emerald-400 border border-emerald-500/20
                            @endif">
                            {{ $assignment->due_date->isPast() ? 'Closed' : 'Active' }}
                        </span>
                    </div>
                    <div>
                        <h4 class="font-bold text-white text-base mb-1">{{ $assignment->title }}</h4>
                        <p class="text-xs text-zinc-500 line-clamp-2">{{ $assignment->description }}</p>
                    </div>
                    <div class="grid grid-cols-3 gap-3 text-center">
                        <div class="bg-white/5 rounded-xl p-2">
                            <p class="text-xs text-zinc-500 mb-0.5">Class</p>
                            <p class="text-xs font-bold text-white truncate">{{ $assignment->classRoom->name }}</p>
                        </div>
                        <div class="bg-white/5 rounded-xl p-2">
                            <p class="text-xs text-zinc-500 mb-0.5">Total Marks</p>
                            <p class="text-sm font-bold text-white">{{ $assignment->total_marks }}</p>
                        </div>
                        <div class="bg-white/5 rounded-xl p-2">
                            <p class="text-xs text-zinc-500 mb-0.5">Submissions</p>
                            <p class="text-sm font-bold text-emerald-400">{{ $assignment->submissions_count }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-xs text-zinc-500 border-t border-white/5 pt-4">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Due {{ $assignment->due_date->format('d M Y') }}
                        </div>
                        <span class="text-zinc-600">{{ $assignment->subject->name ?? 'General' }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Pending Submissions Tab -->
    <div x-show="activeTab === 'submissions'">
        @if($submissions->isEmpty())
            <div class="glass-card p-16 rounded-3xl text-center border border-white/5">
                <p class="text-zinc-500">No pending submissions to review.</p>
            </div>
        @else
            <div class="glass-card rounded-3xl overflow-hidden border border-white/5">
                <table class="w-full text-left text-gray-300">
                    <thead class="bg-white/[0.03] text-xs uppercase tracking-widest font-bold">
                        <tr>
                            <th class="px-6 py-4">Student</th>
                            <th class="px-6 py-4">Assignment</th>
                            <th class="px-6 py-4">Submitted</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($submissions as $submission)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs font-bold">
                                        {{ strtoupper(substr($submission->student->user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-white">{{ $submission->student->user->name }}</div>
                                        <div class="text-xs text-zinc-500">{{ $submission->student->enrollment_number }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-white">{{ $submission->assignment->title }}</div>
                                <div class="text-xs text-zinc-500">Total: {{ $submission->assignment->total_marks }} marks</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-zinc-500">{{ $submission->submitted_at?->diffForHumans() }}</td>
                            <td class="px-6 py-4 text-right">
                                <button @click="selectedSubmission = {{ $submission->id }}" onclick="openGradeModal({{ $submission->id }}, '{{ $submission->assignment->title }}', {{ $submission->assignment->total_marks }})" class="px-4 py-2 text-xs font-bold bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 border border-emerald-500/20 rounded-xl transition-all">
                                    Grade
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Create Assignment Modal -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 py-8">
            <div x-show="showModal" @click="showModal = false" class="fixed inset-0 bg-black/70 backdrop-blur-sm"></div>
            <div class="relative glass-card rounded-3xl shadow-2xl w-full max-w-2xl border border-white/10 p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-white">Create New Assignment</h3>
                    <button @click="showModal = false" class="text-zinc-500 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form action="{{ route('teacher.assignments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-2 gap-5">
                        <div class="col-span-2">
                            <label class="text-xs font-bold text-zinc-500 uppercase mb-2 block tracking-widest">Assignment Title</label>
                            <input type="text" name="title" required placeholder="e.g. Chapter 5 Worksheet" class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-3 outline-none focus:border-emerald-500/50">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-zinc-500 uppercase mb-2 block tracking-widest">Class / Course</label>
                            <select name="class_room_id" required class="w-full bg-[#111] border border-white/10 text-white rounded-xl px-4 py-3 outline-none focus:border-emerald-500/50">
                                @foreach($classRooms as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }} ({{ $class->section }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-zinc-500 uppercase mb-2 block tracking-widest">Subject</label>
                            <select name="subject_id" required class="w-full bg-[#111] border border-white/10 text-white rounded-xl px-4 py-3 outline-none focus:border-emerald-500/50">
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-zinc-500 uppercase mb-2 block tracking-widest">Due Date</label>
                            <input type="date" name="due_date" required class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-3 outline-none focus:border-emerald-500/50">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-zinc-500 uppercase mb-2 block tracking-widest">Total Marks</label>
                            <input type="number" name="total_marks" value="100" min="1" required class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-3 outline-none focus:border-emerald-500/50">
                        </div>
                        <div class="col-span-2">
                            <label class="text-xs font-bold text-zinc-500 uppercase mb-2 block tracking-widest">Instructions</label>
                            <textarea name="description" rows="3" required placeholder="Describe the assignment requirements..." class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-3 outline-none focus:border-emerald-500/50"></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="text-xs font-bold text-zinc-500 uppercase mb-2 block tracking-widest">Attach File (optional)</label>
                            <input type="file" name="file" accept=".pdf,.doc,.docx,.zip" class="w-full text-zinc-400 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-emerald-500/10 file:text-emerald-400 hover:file:bg-emerald-500/20">
                        </div>
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="button" @click="showModal = false" class="flex-1 py-3 bg-white/5 hover:bg-white/10 text-zinc-300 font-bold rounded-xl transition duration-200">Cancel</button>
                        <button type="submit" class="flex-1 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl transition duration-200 shadow-lg shadow-emerald-500/20">Publish Assignment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Grade Submission Modal -->
    <div id="gradeModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div onclick="closeGradeModal()" class="fixed inset-0 bg-black/70 backdrop-blur-sm"></div>
            <div class="relative glass-card rounded-3xl shadow-2xl w-full max-w-md border border-white/10 p-8">
                <h3 class="text-xl font-bold text-white mb-6">Grade Submission</h3>
                <p id="gradeModalTitle" class="text-sm text-zinc-400 mb-6"></p>
                <form id="gradeForm" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="text-xs font-bold text-zinc-500 uppercase mb-2 block tracking-widest">Marks Awarded (out of <span id="totalMarks"></span>)</label>
                        <input type="number" name="marks_awarded" id="marksInput" min="0" required class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-3 outline-none focus:border-emerald-500/50">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-zinc-500 uppercase mb-2 block tracking-widest">Feedback (optional)</label>
                        <textarea name="teacher_feedback" rows="3" placeholder="Provide constructive feedback..." class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-3 outline-none focus:border-emerald-500/50"></textarea>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="closeGradeModal()" class="flex-1 py-3 bg-white/5 hover:bg-white/10 text-zinc-300 font-bold rounded-xl transition duration-200">Cancel</button>
                        <button type="submit" class="flex-1 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl transition duration-200">Submit Grade</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
function openGradeModal(submissionId, title, totalMarks) {
    document.getElementById('gradeModal').classList.remove('hidden');
    document.getElementById('gradeModalTitle').textContent = 'Assignment: ' + title;
    document.getElementById('totalMarks').textContent = totalMarks;
    document.getElementById('marksInput').max = totalMarks;
    document.getElementById('gradeForm').action = '/teacher/submissions/' + submissionId + '/grade';
}
function closeGradeModal() {
    document.getElementById('gradeModal').classList.add('hidden');
}
</script>
</x-teacher-layout>
