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

Route::get('/', Welcome::class);
Route::get('/majors', \App\Livewire\MajorManage::class)->name('majors');
Route::get('/school-years', \App\Livewire\SchoolYearManage::class)->name('school_years');
Route::get('/class-students', \App\Livewire\ClassStudentManage::class)->name('class_students');
Route::get('/subjects', \App\Livewire\SubjectManage::class)->name('subjects');
Route::get('/instructors', \App\Livewire\InstructorManage::class)->name('instructors');
Route::get('/students', \App\Livewire\StudentManage::class)->name('students');
Route::get('/divisions', \App\Livewire\DivisionManage::class)->name('divisions');
Route::get('/attendances', \App\Livewire\AttendanceManage::class)->name('attendances');
Route::get('/attendance-details', \App\Livewire\AttendanceDetailManage::class)->name('attendance_details');
