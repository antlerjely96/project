<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\Admin\InstructorForm;
use App\Models\Instructor;
use App\Models\Major;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class InstructorManage extends Component
{
    use WithPagination;
    use Toast;
    public string $title = 'Instructors';
    public InstructorForm $form;
    public array $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'text-black'],
        ['key' => 'name', 'label' => 'Name', 'class' => 'text-black'],
        ['key' => 'phone', 'label' => 'Phone', 'class' => 'text-black'],
        ['key' => 'account.email', 'label' => 'Email', 'class' => 'text-black'],
        ['key' => 'major.name', 'label' => 'Major', 'class' => 'text-black'],
    ];
    public array $sortBy = [
        'column' => 'id',
        'direction' => 'desc'
    ];
    public string $search = '';
    public bool $drawer = false;
    public bool $instructorModal = false;
    public bool $editMode = false;

    public function instructors(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Instructor::with('account', 'major')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(6);
    }

    public function majors(){
        return Major::all();
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.admin.instructor-manage', [
            'instructors' => $this->instructors(),
            'majors' => $this->majors(),
        ]);
    }

    public function showModal(): void
    {
        $this->form->reset();
        $this->instructorModal = true;
    }

    public function save(): void
    {
        if($this->editMode){
            $this->form->update();
            $this->success('Instructor updated successfully', position: 'toast-top');
        } else {
            $this->form->store();
            $this->success('Instructor created successfully', position: 'toast-top');
        }
        $this->instructorModal = false;
        $this->form->reset();
    }

    public function edit($id): void
    {
        $instructor = Instructor::find($id);
        $this->form->setInstructor($instructor);
        $this->editMode = true;
        $this->instructorModal = true;
    }
}
