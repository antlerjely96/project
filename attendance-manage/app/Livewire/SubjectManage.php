<?php

namespace App\Livewire;

use App\Livewire\Forms\SubjectForm;
use App\Models\Major;
use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;

class SubjectManage extends Component
{
    use WithPagination;
    public SubjectForm $form;
    public string $title = 'Subject';
    public array $sortBy = ['column' => 'id', 'direction' => 'desc'];
    public string $search = '';
    public bool $drawer = false;
    public bool $subjectModal = false;
    public string $titleModal = '';
    public bool $editMode = false;

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $majors = Major::all();
        $headers = [
            ['key' => 'id', 'label' => 'ID', 'class' => 'text-black'],
            ['key' => 'name', 'label' => 'Name', 'class' => 'text-black'],
            ['key' => 'duration', 'label' => 'Duration', 'class' => 'text-black'],
            ['key' => 'major.name', 'label' => 'Major', 'class' => 'text-black'],
        ];
        $subjects = Subject::with('major')
                ->where('name', 'like', '%' . $this->search . '%')
                ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
                ->paginate(6);
        return view('livewire.subject-manage', [
            'subjects' => $subjects,
            'headers' => $headers,
            'majors' => $majors,
        ]);
    }

    public function showModal(): void
    {
        $this->form->reset();
        if ($this->editMode) {
            $this->titleModal = 'Edit Subject';
        } else {
            $this->titleModal = 'Add a Subject';
        }
        $this->subjectModal = true;
    }

    public function save(): void
    {
        if($this->editMode){
            $this->form->update();
        } else {
            $this->form->store();
        }
        $this->subjectModal = false;
    }

    public function edit($id): void
    {
        $subject = Subject::find($id);
        $this->form->setSubject($subject);
        $this->editMode = true;
        $this->subjectModal = true;
    }

    public function delete($id): void
    {
        $subject = Subject::find($id);
        $subject->delete();
    }
}
