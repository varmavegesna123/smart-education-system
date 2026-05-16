<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AiInsightsService;
use App\Models\Mark;
use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\EnrollmentRequest;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Notifications\EnrollmentRequested;

class StudentController extends Controller
{
    public function dashboard(AiInsightsService $insightsService)
    {
        $user = auth()->user();
        $student = $user->student;

        // Auto-create student profile if it doesn't exist
        if (!$student) {
            $student = \App\Models\Student::create([
                'user_id' => $user->id,
                'enrollment_number' => 'STU' . time(),
                'risk_level' => 'Safe'
            ]);
        }

        // 1. Fetch Real Data
        $recentMarks = $student->marks()->with('assessment.subject')->latest()->take(5)->get() ?? collect();
        $attendanceRecords = $student->attendance()->latest('date')->take(10)->get() ?? collect();
        $remedialTasks = $student->remedialTasks()->where('status', 'pending')->get() ?? collect();

        // 2. Calculate Dashboard Stats
        // Attendance %
        $totalDays = $attendanceRecords->count();
        $presentDays = $attendanceRecords->where('status', 'present')->count();
        $attendancePercentage = $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 100; // Default to 100% if no data

        // Learning Score & Progress
        $learningScore = $recentMarks->count() > 0 ? round($recentMarks->avg('marks_obtained')) : 0;
        $progressPercentage = $recentMarks->count() > 0 ? min(100, $learningScore + 5) : 0;

        // 3. Smart Insights
        try {
            $insights = collect($insightsService->generateInsightsForStudent($student));
        } catch (\Exception $e) {
            $insights = collect([]);
        }

        // 4. Chart Data Preparation
        $chartData = [
            'labels' => $recentMarks->pluck('assessment.title')->toArray(),
            'scores' => $recentMarks->pluck('marks_obtained')->toArray(),
        ];

        // 5. Recent Activity Timeline (from real Notifications)
        $activities = $user->notifications()->take(3)->get()->map(function($notif) {
            return [
                'icon' => $notif->data['type'] === 'Enrollment Approved' ? 'CheckCircle' : 'Bell',
                'title' => $notif->data['title'] ?? 'Notification',
                'desc' => $notif->data['message'] ?? '',
                'time' => $notif->created_at->diffForHumans(),
                'color' => 'blue'
            ];
        });

        return view('dashboard.student', compact(
            'student', 'insights', 'recentMarks', 'attendanceRecords', 
            'remedialTasks', 'learningScore', 'attendancePercentage', 
            'progressPercentage', 'chartData', 'activities'
        ));
    }

    public function courses()
    {
        $student = auth()->user()->student;
        if (!$student) return redirect()->back()->with('error', 'Student profile not found.');

        $enrolledIds = $student->classRooms()->pluck('class_rooms.id')->toArray();
        $pendingIds = $student->enrollmentRequests()->where('status', 'pending')->pluck('class_room_id')->toArray();

        $enrolledClasses = $student->classRooms()->with('teacher.user')->get();
        $availableClasses = ClassRoom::whereNotIn('id', array_merge($enrolledIds, $pendingIds))->with('teacher.user')->get();
        $pendingClasses = ClassRoom::whereIn('id', $pendingIds)->with('teacher.user')->get();

        return view('dashboard.courses', compact('enrolledClasses', 'availableClasses', 'pendingClasses'));
    }

    public function sendEnrollmentRequest(Request $request)
    {
        $request->validate(['class_room_id' => 'required|exists:class_rooms,id']);
        
        $student = auth()->user()->student;
        $classRoom = ClassRoom::findOrFail($request->class_room_id);

        if ($student->classRooms()->where('class_rooms.id', $classRoom->id)->exists()) {
            return redirect()->back()->with('error', 'Already enrolled in this class.');
        }

        $enrollment = EnrollmentRequest::firstOrCreate([
            'student_id' => $student->id,
            'class_room_id' => $classRoom->id,
            'teacher_id' => $classRoom->teacher_id
        ], [
            'status' => 'pending',
            'remarks' => 'Student requested enrollment.'
        ]);

        if ($classRoom->teacher && $classRoom->teacher->user) {
            $classRoom->teacher->user->notify(new EnrollmentRequested($enrollment));
        }

        return redirect()->back()->with('success', 'Enrollment request sent successfully.');
    }

    public function attendance()
    {
        $student = auth()->user()->student;
        $records = $student->attendance()->with('classRoom')->latest('date')->get();
        $total = $records->count();
        $present = $records->where('status', 'present')->count();
        $absent = $records->where('status', 'absent')->count();
        $late = $records->where('status', 'late')->count();
        $percentage = $total > 0 ? round(($present / $total) * 100) : 100;
        return view('dashboard.attendance', compact('records', 'total', 'present', 'absent', 'late', 'percentage'));
    }

    public function assessments()
    {
        $student = auth()->user()->student;
        $marks = $student->marks()->with('assessment.subject', 'assessment.classRoom')->latest()->get();
        return view('dashboard.student-assessments', compact('marks'));
    }

    public function assignments()
    {
        $student = auth()->user()->student;
        $classRoomIds = $student->classRooms()->pluck('class_rooms.id');
        
        $assignments = Assignment::whereIn('class_room_id', $classRoomIds)
            ->with(['classRoom', 'subject', 'submissions' => function($q) use ($student) {
                $q->where('student_id', $student->id);
            }])
            ->latest()
            ->get();

        return view('dashboard.student-assignments', compact('assignments'));
    }

    public function submitAssignment(Request $request, $id)
    {
        $request->validate([
            'student_comment' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,zip|max:10240',
        ]);

        $student = auth()->user()->student;
        $assignment = Assignment::findOrFail($id);

        $filePath = $request->file('file')->store('submissions', 'public');

        AssignmentSubmission::updateOrCreate(
            ['assignment_id' => $assignment->id, 'student_id' => $student->id],
            [
                'file_path' => $filePath,
                'student_comment' => $request->student_comment,
                'status' => 'submitted',
                'submitted_at' => now(),
            ]
        );

        return redirect()->back()->with('success', 'Assignment submitted successfully.');
    }

    public function insights()
    {
        $student = auth()->user()->student;
        $insights = $student->user->aiInsights ?? collect();
        return view('dashboard.student-insights', compact('insights'));
    }

    public function remedialTasks()
    {
        $student = auth()->user()->student;
        $tasks = $student->remedialTasks()->with('subject', 'teacher.user')->latest()->get();
        return view('dashboard.student-remedial-tasks', compact('tasks'));
    }

    public function reports()
    {
        $student = auth()->user()->student;
        $marks = $student->marks()->with('assessment.subject')->get();
        $attendanceRecords = $student->attendance()->get();
        $submissions = $student->assignmentSubmissions()->with('assignment')->get();
        
        $totalAttendance = $attendanceRecords->count();
        $presentCount = $attendanceRecords->where('status', 'present')->count();
        $attendancePct = $totalAttendance > 0 ? round(($presentCount / $totalAttendance) * 100) : 100;
        $avgMarks = $marks->count() > 0 ? round($marks->avg('marks_obtained')) : 0;
        $submissionRate = $submissions->count() > 0 ? round(($submissions->where('status', 'submitted')->count() / $submissions->count()) * 100) : 0;

        return view('dashboard.reports', compact('marks', 'attendancePct', 'avgMarks', 'submissionRate', 'submissions'));
    }
}
