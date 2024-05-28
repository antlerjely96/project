<?php

namespace App\Livewire\Admin;

use App\Models\AttendanceDetail;
use App\Models\Student;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class AttendanceDetailManage extends Component
{
    public string $title = 'Attendances';

    public array $headers = [
        ['key' => 'code', 'label' => 'Student code', 'class' => 'text-black'],
        ['key' => 'name', 'label' => 'Student name', 'class' => 'text-black'],
        ['key' => 'attendance_rate', 'label' => 'Rate', 'class' => 'text-black'],
        ['key' => 'total_attended', 'label' => 'Attended', 'class' => 'text-black'],
        ['key' => 'total_absences_without_permission', 'label' => 'Absences without permission', 'class' => 'text-black'],
        ['key' => 'total_late', 'label' => 'Late', 'class' => 'text-black'],
        ['key' => 'total_absences_with_permission', 'label' => 'Absences with permission', 'class' => 'text-black'],
    ];

    public function getDetail($class_student_id, $subject_id, $instructor_id){
        return Student::select('students.id', 'students.code', 'students.name', 'attendances.subject_id')
            ->leftJoin('attendance_details', 'students.id', '=', 'attendance_details.student_id')
            ->leftJoin('attendances', 'attendances.id', '=', 'attendance_details.attendance_id')
            ->where('students.class_student_id', $class_student_id)
            ->where('attendances.subject_id', $subject_id)
            ->groupBy('students.id', 'students.code', 'students.name', 'attendances.subject_id')
            ->selectRaw('COUNT(attendance_details.attendance_id) AS total_session')
            ->selectRaw("COUNT(CASE WHEN attendance_details.attendance_status = 'attended' THEN 1 ELSE NULL END) AS total_attended")
            ->selectRaw("COUNT(CASE WHEN attendance_details.attendance_status = 'absences_without_permission' THEN 1 ELSE NULL END) AS total_absences_without_permission")
            ->selectRaw("COUNT(CASE WHEN attendance_details.attendance_status = 'late' THEN 1 ELSE NULL END) AS total_late")
            ->selectRaw("COUNT(CASE WHEN attendance_details.attendance_status = 'absences_with_permission' THEN 1 ELSE NULL END) AS total_absences_with_permission")
            ->selectRaw("ROUND((((COUNT(CASE WHEN attendance_details.attendance_status = 'attended' THEN 1 ELSE NULL END) + COUNT(CASE WHEN attendance_details.attendance_status = 'late' THEN 1 ELSE NULL END) / 3) / COUNT(attendance_details.attendance_id)) * 100), 2) AS attendance_rate")
            ->get();
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.admin.attendance-detail-manage', [
//            'details' => $this->getDetail()
        ]);
    }
}
