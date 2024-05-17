<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\Admin\StudentForm;
use App\Models\ClassStudent;
use App\Models\Major;
use App\Models\SchoolYear;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;
use Livewire\Attributes\Computed;

class StudentManage extends Component
{
    use WithPagination;
    use Toast;
    public string $title = 'Students';
    public array $sortBy = [
        'column' => 'id',
        'direction' => 'desc'
    ];
    public array $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'text-black'],
        ['key' => 'code', 'label' => 'Student code', 'class' => 'text-black'],
        ['key' => 'name', 'label' => 'Name', 'class' => 'text-black'],
        ['key' => 'phone', 'label' => 'Phone', 'class' => 'text-black'],
        ['key' => 'account.email', 'label' => 'Email', 'class' => 'text-black'],
        ['key' => 'address', 'label' => 'Address', 'class' => 'text-black'],
        ['key' => 'gender', 'label' => 'Gender', 'class' => 'text-black'],
        ['key' => 'date_of_birth', 'label' => 'Birthday', 'class' => 'text-black'],
        ['key' => 'classStudent.name', 'label' => 'Class', 'class' => 'text-black'],
    ];
    public string $search = '';
    public bool $drawer = false;
    public bool $studentModal = false;
    public bool $editMode = false;
    public StudentForm $form;
//    public $classes = [];
    public $selectedMajor = null;
    public $selectedSchoolYear = null;

    public bool $editStudentModal = false;

    public function students(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Student::with('classStudent', 'account')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(6);
    }

    public function allClasses(): \Illuminate\Database\Eloquent\Collection
    {
        return ClassStudent::all();
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.admin.student-manage', [
            'students' => $this->students(),
            'majors' => $this->majors(),
            'schoolYears' => $this->schoolYears(),
            'classes' => $this->allClasses(),
        ]);
    }

    public function showModal(): void
    {
        $this->form->reset();
        $this->editMode = false;
        $this->studentModal = true;
    }

    public function majors(): \Illuminate\Database\Eloquent\Collection
    {
        return Major::all();
    }

    public function schoolYears(): \Illuminate\Database\Eloquent\Collection
    {
        return SchoolYear::all();
    }

    #[Computed]
    public function classes()
    {
        if($this->selectedMajor){
            if($this->selectedSchoolYear){
                return ClassStudent::where('major_id', $this->selectedMajor)
                    ->where('school_year_id', $this->selectedSchoolYear)
                    ->get();
            }
            return ClassStudent::where('major_id', $this->selectedMajor)->get();
        }
        elseif ($this->selectedSchoolYear){
            if($this->selectedMajor){
                return ClassStudent::where('school_year_id', $this->selectedSchoolYear)
                    ->where('major_id', $this->selectedMajor)
                    ->get();
            }
            return ClassStudent::where('school_year_id', $this->selectedSchoolYear)->get();
        }
        return [];
    }

    public function save(): void
    {
        if($this->editMode){
            $this->form->update();
            $this->editStudentModal = false;
            $this->success('Student updated successfully');
        } else {
            $this->form->store();
            $this->studentModal = false;
            $this->success('Student created successfully');
        }
        $this->form->reset();
    }

    public function edit($id): void
    {
        $student = Student::find($id);
        $this->form->setStudent($student);
        $this->editMode = true;
        $this->editStudentModal = true;
    }

    public function delete($id): void
    {
        $student = Student::find($id);
        $student->delete();
        $this->success('Student deleted successfully');
    }

    public function resetPassword($id): void
    {
        $student = Student::find($id);
        $student->account->update([
            'password' => bcrypt('123456'),
        ]);
        $this->success('Password reset successfully');
    }

    public function lockedAccount($id): void
    {
        $student = Student::find($id);
        $student->account->update([
            'locked' => '1',
        ]);
        $this->success('Locked Account');
    }

    public function unlockedAccount($id): void
    {
        $student = Student::find($id);
        $student->account->update([
            'locked' => '0',
        ]);
        $this->success('Unlocked Account');
    }
}
