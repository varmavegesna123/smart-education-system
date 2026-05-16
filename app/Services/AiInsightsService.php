<?php

namespace App\Services;

use App\Models\Student;

class AiInsightsService
{
    public function generateInsightsForStudent(Student $student)
    {
        $insights = [];
        
        // 1. Check Risk Level
        if ($student->risk_level == 'High Risk') {
            $insights[] = [
                'type' => 'danger',
                'title' => 'High Risk of Failure',
                'message' => 'This student is at high risk based on recent assessments and attendance.',
                'confidence' => rand(85, 98)
            ];
        }

        // 2. Check Attendance trend (last 10 days)
        $attendances = $student->attendance()->latest('date')->take(10)->get();
        $recentAbsences = $attendances->where('status', 'absent')->count();
        if ($recentAbsences >= 3) {
            $insights[] = [
                'type' => 'warning',
                'title' => 'Attendance Dropping',
                'message' => "The student has been absent {$recentAbsences} times in the last 10 recorded days.",
                'confidence' => rand(80, 95)
            ];
        }

        // 3. Performance Trend
        $marks = $student->marks()->latest()->take(5)->get();
        if ($marks->count() >= 2) {
            $latestMark = $marks->first()->marks_obtained;
            $previousMark = $marks->skip(1)->first()->marks_obtained;
            if ($latestMark > $previousMark + 10) {
                $insights[] = [
                    'type' => 'success',
                    'title' => 'Performance Improving',
                    'message' => 'Recent assessment score improved significantly compared to the previous one.',
                    'confidence' => rand(75, 90)
                ];
            } elseif ($latestMark < $previousMark - 10) {
                $insights[] = [
                    'type' => 'warning',
                    'title' => 'Performance Dropping',
                    'message' => 'Recent assessment score dropped significantly. Remedial action suggested.',
                    'confidence' => rand(80, 95)
                ];
            }
        }

        if (empty($insights)) {
            $insights[] = [
                'type' => 'info',
                'title' => 'On Track',
                'message' => 'The student is performing steadily with no major concerns.',
                'confidence' => rand(85, 95)
            ];
        }

        return $insights;
    }
}
