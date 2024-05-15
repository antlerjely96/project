<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\Admin\SchoolYearForm;
use App\Models\SchoolYear;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class SchoolYearManage extends Component
{
    use WithPagination;
    use Toast;
    public string $title = 'School Years';
    public array $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'text-black'],
        ['key' => 'name', 'label' => 'Name', 'class' => 'text-black'],
        ['key' => 'start_year', 'label' => 'Start year', 'class' => 'text-black'],
        ['key' => 'end_year', 'label' => 'End year', 'class' => 'text-black'],
    ];
    public array $sortBy = [
        'column' => 'id',
        'direction' => 'desc'
    ];
    public bool $schoolYearModal = false;
    public string $search = '';
    public bool $editMode = false;
    public bool $drawer = false;
    public SchoolYearForm $form;

    public function schoolYears(){
        return SchoolYear::where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(6);
    }
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.admin.school-year-manage', [
            'schoolYears' => $this->schoolYears()
        ]);
    }

    public function showModal(): void
    {
        $this->form->reset();
        $this->schoolYearModal = true;
    }

    public function save(): void
    {
        if($this->editMode){
            $this->form->update();
            $this->success('School year updated successfully.', position: 'toast-top');
        } else {
            $this->form->store();
            $this->success('School year created successfully.', position: 'toast-top');
        }
        $this->schoolYearModal = false;
    }

    public function edit($id): void
    {
        $schoolYear = SchoolYear::find($id);
        $this->form->setSchoolYear($schoolYear);
        $this->editMode = true;
        $this->schoolYearModal = true;
    }

    public function delete($id): void
    {
        $schoolYear = SchoolYear::find($id);
        $schoolYear->delete();
        $this->success('School year deleted successfully.', position: 'toast-top');
    }
}
