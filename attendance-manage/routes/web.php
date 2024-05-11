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
