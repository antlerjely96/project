<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\Admin\SubjectForm;
use App\Models\Major;
use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class SubjectManage extends Component
{
    use WithPagination;
    use Toast;
    public string $title = 'Subjects';
    public array $sortBy = [
        'column' => 'id',
        'direction' => 'desc'
    ];
    public array $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'text-black'],
        ['key' => 'name', 'label' => 'Name', 'class' => 'text-black'],
        ['key' => 'duration', 'label' => 'Duration', 'class' => 'text-black'],
        ['key' => 'major.name', 'label' => 'Major', 'class' => 'text-black'],
    ];
    public string $search = '';
    public bool $drawer = false;
    public bool $subjectModal = false;
    public bool $editMode = false;
    public SubjectForm $form;

    public function subjects(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Subject::with('major')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(6);
    }

    public function majors(): \Illuminate\Database\Eloquent\Collection
    {
        return Major::all();
    }
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.admin.subject-manage', [
            'subjects' => $this->subjects(),
            'majors' => $this->majors(),
        ]);
    }

    public function showModal(): void
    {
        $this->form->reset();
        $this->subjectModal = true;
    }

    public function save(): void
    {
        if ($this->editMode) {
            $this->form->update();
            $this->success('Subject updated successfully');
        } else {
            $this->form->store();
            $this->success('subject created successfully');
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
        $this->success('Subject deleted successfully');
    }
}
