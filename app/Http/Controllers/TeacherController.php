<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\Teacher;
use App\Models\User;
use App\Models\EnrollmentRequest;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Subject;
use App\Models\AttendanceSession;
use App\Models\Attendance;
use App\Notifications\EnrollmentApproved;
use App\Notifications\NewAssignmentCreated;
use App\Notifications\AssignmentGraded;
use App\Services\SlowLearnerEngineService;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        
        // Auto-provision a Teacher profile if it doesn't exist to prevent crashes
        $teacher = $user->teacher;
        if (!$teacher) {
            $teacher = Teacher::create([
                'user_id' => $user->id,
                'employee_id' => 'EMP-' . strtoupper(substr(uniqid(), -6)),
                'department' => 'Computer Science',
                'designation' => 'Assistant Professor',
            ]);
            // Re-fetch to load relationships
            $teacher = Teacher::find($teacher->id);
        }

        $classRoom = $teacher->classRooms()->first();
        $students = $classRoom ? $classRoom->students()->with('marks', 'attendance')->get() : collect();

        // 1. KPI Calculations
        $totalStudents = $students->count();
        $avgAttendance = $students->count() > 0 
            ? round($students->avg(function ($s) { return $s->attendancePercentage(); })) 
            : 0;
        $classAverage = $students->count() > 0 
            ? round($students->avg(function ($s) { return $s->marks->avg('marks_obtained'); })) 
            : 0;
        $pendingTasks = 0; // In a real app, query assignment submissions with status 'Pending'

        // 2. Class Analytics Chart Data (Weekly Performance)
        $performanceChartData = [
            'labels' => ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6'],
            'class_avg' => [65, 68, 70, 75, 74, 78], // This would normally be aggregated from DB grouped by week
            'subject_high' => [85, 82, 88, 89, 90, 92]
        ];

        // 3. AI Risk Detection (At-Risk Students)
        $highRiskStudents = $students->where('risk_level', 'High Risk');
        $riskAlerts = [];
        foreach($highRiskStudents->take(3) as $rs) {
            $riskAlerts[] = [
                'id' => $rs->id,
                'name' => $rs->user->name,
                'avatar' => substr($rs->user->name, 0, 1),
                'risk_level' => 85,
                'reason' => 'Consistent low performance and missing assignments.',
                'subject' => 'Various',
                'action' => 'Schedule Meeting'
            ];
        }

        // 4. Data Table Roster
        $roster = [];
        foreach($students as $s) {
            $roster[] = [
                'id' => $s->id,
                'name' => $s->user->name,
                'email' => $s->user->email,
                'percentage' => round($s->marks->avg('marks_obtained') ?? 0),
                'attendance' => $s->attendancePercentage(),
                'status' => $s->risk_level === 'High Risk' ? 'At Risk' : 'On Track'
            ];
        }

        $pendingRequests = $teacher->enrollmentRequests()->with('student.user', 'classRoom')->where('status', 'pending')->get();

        return view('dashboard.teacher', compact(
            'teacher', 
            'classRoom', 
            'totalStudents', 
            'avgAttendance', 
            'classAverage', 
            'pendingTasks',
            'performanceChartData',
            'riskAlerts',
            'roster',
            'pendingRequests'
        ));
    }

    public function students()
    {
        $teacher = auth()->user()->teacher;
        $classRooms = $teacher->classRooms->load('students.user');
        return view('dashboard.teacher-students', compact('classRooms'));
    }

    public function attendance(Request $request)
    {
        $teacher = auth()->user()->teacher;
        $classRooms = $teacher->classRooms->load('students.user');
        $selectedClassId = $request->get('class_room_id', $classRooms->first()?->id);
        $date = $request->get('date', today()->toDateString());
        $selectedClass = $classRooms->find($selectedClassId);

        // Fetch existing attendance for this session
        $existing = Attendance::where('class_room_id', $selectedClassId)
            ->where('date', $date)
            ->pluck('status', 'student_id');

        // Past sessions for the selected class
        $sessions = AttendanceSession::where('class_room_id', $selectedClassId)
            ->with('attendances')
            ->latest('date')->take(5)->get();

        return view('dashboard.teacher-attendance', compact('classRooms', 'selectedClass', 'date', 'existing', 'sessions'));
    }

    public function storeAttendance(Request $request)
    {
        $request->validate([
            'class_room_id' => 'required|exists:class_rooms,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
        ]);

        $teacher = auth()->user()->teacher;

        $session = AttendanceSession::firstOrCreate([
            'class_room_id' => $request->class_room_id,
            'date' => $request->date,
        ], [
            'teacher_id' => $teacher->id,
        ]);

        foreach ($request->attendance as $studentId => $status) {
            Attendance::updateOrCreate(
                ['student_id' => $studentId, 'class_room_id' => $request->class_room_id, 'date' => $request->date],
                ['status' => $status, 'attendance_session_id' => $session->id]
            );
        }

        return redirect()->back()->with('success', 'Attendance saved for ' . $request->date);
    }

    public function assessments()
    {
        return view('dashboard.teacher-assessments');
    }

    public function assignments()
    {
        $teacher = auth()->user()->teacher;
        $classRooms = $teacher->classRooms;
        $subjects = Subject::all();
        $assignments = Assignment::where('teacher_id', $teacher->id)
            ->with('classRoom', 'subject')
            ->withCount('submissions')
            ->latest()
            ->get();
        
        $submissions = AssignmentSubmission::whereHas('assignment', function($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })
            ->with('assignment', 'student.user')
            ->where('status', 'submitted')
            ->latest()
            ->get();

        return view('dashboard.teacher-assignments', compact('assignments', 'submissions', 'classRooms', 'subjects'));
    }

    public function storeAssignment(Request $request)
    {
        $request->validate([
            'class_room_id' => 'required|exists:class_rooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'total_marks' => 'required|integer|min:1',
            'file' => 'nullable|file|mimes:pdf,doc,docx,zip|max:10240',
        ]);

        $teacher = auth()->user()->teacher;

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('assignments', 'public');
        }

        $assignment = Assignment::create([
            'teacher_id' => $teacher->id,
            'class_room_id' => $request->class_room_id,
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'total_marks' => $request->total_marks,
            'file_path' => $filePath,
        ]);

        // Notify enrolled students
        $students = $assignment->classRoom->students;
        foreach ($students as $student) {
            if ($student->user) {
                $student->user->notify(new NewAssignmentCreated($assignment));
            }
        }

        return redirect()->back()->with('success', 'Assignment created and students notified.');
    }

    public function gradeSubmission(Request $request, $id)
    {
        $request->validate([
            'marks_awarded' => 'required|integer|min:0',
            'teacher_feedback' => 'nullable|string',
        ]);

        $submission = AssignmentSubmission::findOrFail($id);
        $submission->update([
            'marks_awarded' => $request->marks_awarded,
            'teacher_feedback' => $request->teacher_feedback,
            'status' => 'reviewed',
        ]);

        if ($submission->student->user) {
            $submission->student->user->notify(new AssignmentGraded($submission));
        }

        return redirect()->back()->with('success', 'Submission graded successfully.');
    }

    public function analytics()
    {
        $teacher = auth()->user()->teacher;
        $classRooms = $teacher->classRooms->load('students');
        
        $totalStudents = 0;
        $riskCounts = ['Safe' => 0, 'Medium Risk' => 0, 'High Risk' => 0];
        foreach ($classRooms as $class) {
            foreach ($class->students as $student) {
                $totalStudents++;
                $riskCounts[$student->risk_level] = ($riskCounts[$student->risk_level] ?? 0) + 1;
            }
        }

        return view('dashboard.teacher-analytics', compact('classRooms', 'totalStudents', 'riskCounts'));
    }

    public function studyMaterials()
    {
        $teacher = auth()->user()->teacher;
        $materials = $teacher->studyMaterials()->with('classRoom', 'subject')->latest()->get();
        $classRooms = $teacher->classRooms;
        $subjects = Subject::all();
        return view('dashboard.teacher-study-materials', compact('materials', 'classRooms', 'subjects'));
    }

    public function settings()
    {
        return view('dashboard.teacher-settings');
    }

    public function storeClassRoom(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $teacher = auth()->user()->teacher;
        
        $classRoom = ClassRoom::create([
            'name' => $request->name,
            'section' => $request->section,
            'description' => $request->description,
            'teacher_id' => $teacher->id,
        ]);

        return redirect()->back()->with('success', 'Class created successfully.');
    }

    public function approveEnrollment($id)
    {
        $enrollment = EnrollmentRequest::findOrFail($id);
        
        // Ensure this teacher owns this request
        if ($enrollment->teacher_id !== auth()->user()->teacher->id) {
            abort(403);
        }

        $enrollment->update(['status' => 'approved', 'remarks' => 'Approved by teacher.']);
        
        // Attach student to class
        $enrollment->student->classRooms()->syncWithoutDetaching([$enrollment->class_room_id]);

        // Notify Student
        if ($enrollment->student->user) {
            $enrollment->student->user->notify(new EnrollmentApproved($enrollment));
        }

        return redirect()->back()->with('success', 'Enrollment approved.');
    }

    public function rejectEnrollment($id)
    {
        $enrollment = EnrollmentRequest::findOrFail($id);
        
        if ($enrollment->teacher_id !== auth()->user()->teacher->id) {
            abort(403);
        }

        $enrollment->update(['status' => 'rejected', 'remarks' => 'Rejected by teacher.']);

        return redirect()->back()->with('success', 'Enrollment rejected.');
    }
}
