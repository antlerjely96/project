<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\Admin\MajorForm;
use App\Models\Major;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class MajorManage extends Component
{
    use WithPagination;
    use Toast;
    public string $title = "Majors";
    public array $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'text-black'],
        ['key' => 'name', 'label' => 'Name', 'class' => 'text-black'],
    ];
    public array $sortBy = [
        'column' => 'id',
        'direction' => 'desc'
    ];
    public bool $drawer = false;
    public bool $majorModal = false;
    public MajorForm $form;
    public string $search = '';
    public bool $editMode = false;

    public function majors(){
        return Major::where('name', 'like', '%'.$this->search.'%')
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(6);

    }
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.admin.major-manage', [
            'majors' => $this->majors(),
        ]);
    }

    public function showModal(): void
    {
        $this->form->reset();
        $this->majorModal = true;
    }

    public function save(): void
    {
        if ($this->editMode) {
            $this->form->update();
            $this->success('Major updated successfully.', position: 'toast-top');
        } else {
            $this->form->store();
            $this->success('Major created successfully.', position: 'toast-top');
        }
        $this->majorModal = false;
    }

    public function edit($id): void
    {
        $major = Major::find($id);
        $this->form->setMajor($major);
        $this->majorModal = true;
        $this->editMode = true;
    }

    public function delete($id): void
    {
        $major = Major::find($id);
        $major->delete();
        $this->success('Major deleted successfully.', position: 'toast-top');
    }
}
