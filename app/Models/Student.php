<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'class_room_id',
        'enrollment_number',
        'dob',
        'gender',
        'address',
        'guardian_name',
        'guardian_phone',
        'risk_level' // 'Safe', 'Medium Risk', 'High Risk'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classRooms()
    {
        return $this->belongsToMany(ClassRoom::class, 'class_room_student');
    }

    public function enrollmentRequests()
    {
        return $this->hasMany(EnrollmentRequest::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    public function remedialTasks()
    {
        return $this->hasMany(RemedialTask::class);
    }

    public function assignmentSubmissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    public function attendancePercentage()
    {
        $total = $this->attendance()->count();
        if ($total == 0) return 100; // Assume 100% if no records yet
        
        $present = $this->attendance()->where('status', 'present')->count();
        return round(($present / $total) * 100);
    }
}
