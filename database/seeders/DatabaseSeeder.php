<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\Subject;
use App\Models\Assessment;
use App\Models\Mark;
use App\Models\Attendance;
use App\Models\RemedialTask;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\StudyMaterial;
use App\Models\Notification;
use App\Models\AttendanceSession;
use App\Models\AiInsight;
use App\Models\EnrollmentRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Permissions & Roles
        $permissions = [
            'manage assessments', 'manage attendance', 'upload marks', 'create assignments', 'upload study materials',
            'view assignments', 'view attendance', 'submit assignments', 'view insights'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        $teacherRole->givePermissionTo(['manage assessments', 'manage attendance', 'upload marks', 'create assignments', 'upload study materials']);

        $studentRole = Role::firstOrCreate(['name' => 'student']);
        $studentRole->givePermissionTo(['view assignments', 'view attendance', 'submit assignments', 'view insights']);

        // 2. Admin User
        $admin = User::firstOrCreate([
            'email' => 'admin@smartedu.com'
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        // 3. Teachers (10)
        $teachers = [];
        for ($i = 1; $i <= 10; $i++) {
            $email = $i === 1 ? 'teacher@smartedu.com' : "teacher$i@smartedu.com";
            
            $tUser = User::firstOrCreate([
                'email' => $email
            ], [
                'name' => "Teacher $i",
                'password' => Hash::make('password')
            ]);
            $tUser->assignRole('teacher');
            $teachers[] = Teacher::firstOrCreate(
                ['user_id' => $tUser->id],
                ['department' => $i % 2 == 0 ? 'Science' : 'Arts']
            );
        }

        // 4. Subjects & ClassRooms
        $math = Subject::firstOrCreate(['code' => 'MAT101'], ['name' => 'Mathematics', 'description' => 'Advanced Math', 'credits' => 4]);
        $sci = Subject::firstOrCreate(['code' => 'SCI101'], ['name' => 'Science', 'description' => 'General Science', 'credits' => 3]);
        $eng = Subject::firstOrCreate(['code' => 'ENG101'], ['name' => 'English', 'description' => 'Literature', 'credits' => 2]);

        $class10A = ClassRoom::firstOrCreate(['name' => 'Class 10', 'section' => 'A'], ['description' => 'Section A Batch', 'teacher_id' => $teachers[0]->id]);
        $class10B = ClassRoom::firstOrCreate(['name' => 'Class 10', 'section' => 'B'], ['description' => 'Section B Batch', 'teacher_id' => $teachers[1]->id]);

        // Attach teachers to classes & subjects
        $class10A->subjects()->syncWithoutDetaching([
            $math->id => ['teacher_id' => $teachers[0]->id],
            $sci->id => ['teacher_id' => $teachers[1]->id]
        ]);
        $class10B->subjects()->syncWithoutDetaching([
            $eng->id => ['teacher_id' => $teachers[2]->id]
        ]);

        // 5. Students (100)
        $students = [];
        for ($i = 1; $i <= 100; $i++) {
            $email = $i === 1 ? 'student@smartedu.com' : "student$i@smartedu.com";
            
            $sUser = User::firstOrCreate([
                'email' => $email
            ], [
                'name' => "Student $i",
                'password' => Hash::make('password')
            ]);
            $sUser->assignRole('student');
            
            $risk = 'Safe';
            if ($i % 10 == 0) $risk = 'High Risk';
            elseif ($i % 5 == 0) $risk = 'Medium Risk';

            $student = Student::firstOrCreate(
                ['user_id' => $sUser->id],
                [
                    'enrollment_number' => "STU2024" . str_pad($i, 4, '0', STR_PAD_LEFT),
                    'risk_level' => $risk
                ]
            );

            // Pivot Table `class_room_student` Enrollment
            $classId = $i <= 50 ? $class10A->id : $class10B->id;
            $teacherId = $i <= 50 ? $teachers[0]->id : $teachers[1]->id;
            $student->classRooms()->syncWithoutDetaching([$classId]);

            // Create some sample pending enrollment requests for random students
            if ($i > 90) {
                EnrollmentRequest::firstOrCreate([
                    'student_id' => $student->id,
                    'class_room_id' => $class10A->id,
                    'teacher_id' => $teachers[0]->id,
                ], [
                    'status' => 'pending',
                    'remarks' => 'I would like to join this class.'
                ]);
            } else {
                // If they are enrolled, let's say they have an approved request
                EnrollmentRequest::firstOrCreate([
                    'student_id' => $student->id,
                    'class_room_id' => $classId,
                    'teacher_id' => $teacherId,
                ], [
                    'status' => 'approved',
                    'remarks' => 'Approved automatically.'
                ]);
            }

            $students[] = $student;
        }

        // 6. Assessments & Marks
        $assessment1 = Assessment::firstOrCreate(
            ['title' => 'Midterm Math Exam', 'class_room_id' => $class10A->id],
            [
                'type' => 'exam',
                'subject_id' => $math->id,
                'teacher_id' => $teachers[0]->id,
                'total_marks' => 100,
                'date' => Carbon::now()->subDays(10)
            ]
        );

        foreach ($students as $student) {
            // Check if student is in class 10A
            if ($student->classRooms()->where('class_rooms.id', $class10A->id)->exists()) {
                // Determine marks based on risk level
                $marksObtained = 85;
                if ($student->risk_level == 'High Risk') $marksObtained = rand(30, 45);
                elseif ($student->risk_level == 'Medium Risk') $marksObtained = rand(50, 65);
                else $marksObtained = rand(70, 95);

                Mark::firstOrCreate(
                    ['assessment_id' => $assessment1->id, 'student_id' => $student->id],
                    ['marks_obtained' => $marksObtained, 'feedback' => 'Automated feedback']
                );

                // Attendance Sessions & Attendance
                for($d = 1; $d <= 5; $d++) {
                    $date = Carbon::now()->subDays($d);
                    
                    // Create Session (only once per day/class/subject)
                    $session = AttendanceSession::firstOrCreate([
                        'teacher_id' => $teachers[0]->id,
                        'class_room_id' => $class10A->id,
                        'subject_id' => $math->id,
                        'date' => $date->toDateString()
                    ]);

                    Attendance::firstOrCreate(
                        ['student_id' => $student->id, 'class_room_id' => $class10A->id, 'date' => $date->toDateString()],
                        [
                            'status' => $student->risk_level == 'High Risk' && $d % 2 == 0 ? 'absent' : 'present',
                            'attendance_session_id' => $session->id
                        ]
                    );
                }
            }
        }
        
        // 7. Assignments & Submissions
        $assignment = Assignment::firstOrCreate([
            'teacher_id' => $teachers[0]->id,
            'class_room_id' => $class10A->id,
            'subject_id' => $math->id,
            'title' => 'Calculus Assignment 1',
        ], [
            'description' => 'Solve problems 1-20 in chapter 4.',
            'due_date' => Carbon::now()->addDays(5),
            'total_marks' => 50
        ]);

        foreach ($students as $student) {
            if ($student->classRooms()->where('class_rooms.id', $class10A->id)->exists()) {
                $status = 'submitted';
                if ($student->risk_level == 'High Risk') $status = 'pending';
                
                if ($status == 'submitted') {
                    AssignmentSubmission::firstOrCreate([
                        'assignment_id' => $assignment->id,
                        'student_id' => $student->id
                    ], [
                        'status' => 'submitted',
                        'submitted_at' => Carbon::now()->subDays(1),
                        'student_comment' => 'Completed all problems.'
                    ]);
                }
            }
        }

        // 8. Study Materials
        StudyMaterial::firstOrCreate([
            'teacher_id' => $teachers[0]->id,
            'class_room_id' => $class10A->id,
            'subject_id' => $math->id,
            'title' => 'Calculus Chapter 4 Notes',
        ], [
            'type' => 'PDF',
            'url' => '#'
        ]);

        // 9. Remedial Tasks
        $highRiskStudents = Student::where('risk_level', 'High Risk')->get();
        foreach($highRiskStudents as $hrStudent) {
             RemedialTask::firstOrCreate([
                 'student_id' => $hrStudent->id,
                 'subject_id' => $math->id
             ], [
                 'teacher_id' => $teachers[0]->id,
                 'title' => 'Extra Algebra Practice',
                 'description' => 'Complete the attached worksheet on polynomial equations.',
                 'due_date' => Carbon::now()->addDays(3),
                 'status' => 'pending'
             ]);

             // AiInsights & Notifications for High Risk students
             AiInsight::firstOrCreate([
                 'user_id' => $hrStudent->user_id,
                 'type' => 'PerformancePrediction'
             ], [
                 'insight_text' => 'High risk of failing Mathematics. Recommend 2 hours of extra practice weekly.',
                 'confidence_score' => 92,
                 'is_actionable' => true
             ]);

             Notification::firstOrCreate([
                 'user_id' => $hrStudent->user_id,
                 'title' => 'New Remedial Task Assigned',
             ], [
                 'type' => 'Assignment',
                 'message' => 'Teacher 1 assigned you Extra Algebra Practice.',
                 'is_read' => false
             ]);
        }
    }
}
