<?php

namespace App\Livewire;

use App\Livewire\Forms\ClassStudentForm;
use App\Models\ClassStudent;
use App\Models\Major;
use App\Models\SchoolYear;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\View\Components\Drawer;

class ClassStudentManage extends Component
{
    use WithPagination;
    public string $title = 'Class Student';
    public array $sortBy = ['column' => 'id', 'direction' => 'desc'];
    public string $search = '';
    public bool $drawer = false;
    public ClassStudentForm $form;
    public bool $editMode = false;
    public bool $classModal = false;


    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $major = Major::all();
        $schoolYear = SchoolYear::all();
        $classes = ClassStudent::with('major', 'schoolYear')
                ->where('name', 'like', '%' . $this->search . '%')
                ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
                ->paginate(6);
        $headers = [
            ['key' => 'id', 'label' => 'ID', 'class' => 'text-black'],
            ['key' => 'name', 'label' => 'Class Name', 'class' => 'text-black'],
            ['key' => 'major.name', 'label' => 'Major', 'class' => 'text-black'],
            ['key' => 'schoolYear.name', 'label' => 'School Year', 'class' => 'text-black'],
        ];
        return view('livewire.class-student-manage', [
            'classes' => $classes,
            'headers' => $headers,
            'majors' => $major,
            'schoolYears' => $schoolYear,
        ]);
    }

    public function showModal(): void
    {
        $this->form->reset();
        $this->classModal = true;
    }

    public function save(): void
    {
        if($this->editMode){
            $this->form->update();
        } else {
            $this->form->store();
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
    }
}
