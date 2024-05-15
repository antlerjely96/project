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
Route::prefix('/Admin')->group(function (){
    Route::get('/majors', \App\Livewire\Admin\MajorManage::class)->name('admin.majors');
    Route::get('/school-years', \App\Livewire\Admin\SchoolYearManage::class)->name('admin.school-years');
    Route::get('/classes', \App\Livewire\Admin\ClassStudentManage::class)->name('admin.classes');
});
