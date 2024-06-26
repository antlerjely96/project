<?php

use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', \App\Livewire\AccountManage::class)->name('login');
Route::get('/logout', [\App\Livewire\AccountManage::class, 'logout'])->name('logout');
Route::middleware('login')->prefix('/Admin')->group(function (){
    Route::get('/majors', \App\Livewire\Admin\MajorManage::class)->name('admin.majors');
    Route::get('/school-years', \App\Livewire\Admin\SchoolYearManage::class)->name('admin.school-years');
    Route::get('/classes', \App\Livewire\Admin\ClassStudentManage::class)->name('admin.classes');
    Route::get('/students', \App\Livewire\Admin\StudentManage::class)->name('admin.students');
    Route::get('/subjects', \App\Livewire\Admin\SubjectManage::class)->name('admin.subjects');
    Route::get('/instructors', \App\Livewire\Admin\InstructorManage::class)->name('admin.instructors');
    Route::get('/divisions', \App\Livewire\Admin\DivisionManage::class)->name('admin.divisions');
    Route::get('/attendances', \App\Livewire\Admin\AttendanceManage::class)->name('admin.attendances');
    Route::get('/admins', \App\Livewire\Admin\AdminManage::class)->name('admin.admins');
//    Route::get('/attendance-details/{class_student_id}/{subject_id}/{instructor_id}', \App\Livewire\Admin\AttendanceDetailManage::class)->name('admin.attendance-details');
});

Route::middleware('login')->prefix('/Instructor')->group(function(){
    Route::get('/attendances', \App\Livewire\Instructor\AttendanceManage::class)->name('instructor.attendances');
    Route::get('/instructors', \App\Livewire\Instructor\InstructorManage::class)->name('instructor.instructors');
});
