<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\Admin\ClassStudentForm;
use App\Models\ClassStudent;
use App\Models\Major;
use App\Models\SchoolYear;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ClassStudentManage extends Component
{
    use WithPagination;
    use Toast;
    public string $title = 'Classes';
    public array $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'text-black'],
        ['key' => 'name', 'label' => 'Class Name', 'class' => 'text-black'],
        ['key' => 'major.name', 'label' => 'Major', 'class' => 'text-black'],
        ['key' => 'schoolYear.name', 'label' => 'School Year', 'class' => 'text-black'],
    ];
    public array $sortBy = [
        'column' => 'id',
        'direction' => 'desc'
    ];
    public string $search = '';
    public bool $drawer = false;
    public bool $classModal = false;
    public bool $editMode = false;
    public ClassStudentForm $form;

    public function classes(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return ClassStudent::with('major', 'schoolYear')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(6);
    }

    public function majors(): \Illuminate\Database\Eloquent\Collection
    {
        return Major::all();
    }

    public function schoolYears(): \Illuminate\Database\Eloquent\Collection
    {
        return SchoolYear::all();
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.admin.class-student-manage', [
            'classes' => $this->classes(),
            'majors' => $this->majors(),
            'schoolYears' => $this->schoolYears(),
        ]);
    }

    public function showModal(): void
    {
        $this->form->reset();
        $this->classModal = true;
    }

    public function save(): void
    {
        if ($this->editMode) {
            $this->form->update();
            $this->success('Class updated successfully.', position: 'toast-top');
        } else {
            $this->form->store();
            $this->success('Class created successfully.', position: 'toast-top');
        }
        $this->classModal = false;
    }

    public function edit($id): void
    {
        $class = ClassStudent::find($id);
        $this->form->setClassStudent($class);
        $this->editMode = true;
        $this->classModal = true;
    }

    public function delete($id): void
    {
        $class = ClassStudent::find($id);
        $class->delete();
        $this->success('Class deleted successfully.', position: 'toast-top');
    }
}
