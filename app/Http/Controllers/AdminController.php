<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ClassRoom;
use App\Models\User;
use App\Models\RemedialTask;
use App\Models\Subject;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_students' => Student::count(),
            'total_teachers' => Teacher::count(),
            'total_classes' => ClassRoom::count(),
            'high_risk_students' => Student::where('risk_level', 'High Risk')->count(),
        ];

        $users = User::with('roles')->get();
        $classRooms = ClassRoom::with('teacher.user', 'subjects')->get();
        $remedialTasks = RemedialTask::with('student.user', 'teacher.user', 'subject')->get();
        $teachers = Teacher::with('user')->get();
        $students = Student::with('user')->get();
        $subjects = Subject::all();

        return view('dashboard.admin', compact('stats', 'users', 'classRooms', 'remedialTasks', 'teachers', 'students', 'subjects'));
    }

    public function storeClassRoom(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'description' => 'nullable|string',
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        ClassRoom::create($request->all());

        return redirect()->back()->with('success', 'Course created successfully.');
    }

    public function destroyClassRoom($id)
    {
        ClassRoom::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Course deleted successfully.');
    }

    public function storeRemedialTask(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
        ]);

        RemedialTask::create($request->all());

        return redirect()->back()->with('success', 'Remedial task created successfully.');
    }

    public function destroyRemedialTask($id)
    {
        RemedialTask::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Remedial task deleted successfully.');
    }
}
