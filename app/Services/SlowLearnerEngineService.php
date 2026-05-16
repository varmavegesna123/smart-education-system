<?php

namespace App\Services;

use App\Models\Student;

class SlowLearnerEngineService
{
    /**
     * Calculates and updates the risk level for a student.
     */
    public function analyzeStudent(Student $student)
    {
        $marks = $student->marks()->with('assessment')->get();
        $attendances = $student->attendance()->get();

        $avgMarks = $marks->avg('marks_obtained') ?? 100; // default 100 if no exams
        
        $totalDays = $attendances->count();
        $presentDays = $attendances->where('status', 'present')->count();
        $attendancePercentage = $totalDays > 0 ? ($presentDays / $totalDays) * 100 : 100;

        // Weighted score: 70% marks, 30% attendance
        $score = ($avgMarks * 0.7) + ($attendancePercentage * 0.3);

        $riskLevel = 'Safe';
        if ($score < 40) {
            $riskLevel = 'High Risk';
        } elseif ($score < 60) {
            $riskLevel = 'Medium Risk';
        }

        $student->update(['risk_level' => $riskLevel]);

        return [
            'score' => round($score, 2),
            'risk_level' => $riskLevel,
            'avg_marks' => round($avgMarks, 2),
            'attendance_percentage' => round($attendancePercentage, 2)
        ];
    }

    public function analyzeClass(int $classRoomId)
    {
        $students = Student::where('class_room_id', $classRoomId)->get();
        $results = [];
        foreach ($students as $student) {
            $results[$student->id] = $this->analyzeStudent($student);
        }
        return $results;
    }
}
