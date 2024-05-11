<?php

namespace App\Livewire;

use App\Livewire\Forms\SchoolYearForm;
use App\Models\SchoolYear;
use Livewire\Component;
use Livewire\WithPagination;

class SchoolYearManage extends Component
{
    use WithPagination;
    public SchoolYearForm $form;
    public string $title = "School Year";
    public bool $editMode = false;
    public bool $schoolYearModal = false;
    public string $search = '';
    public bool $drawer = false;

    public array $sortBy = ['column' => 'id', 'direction' => 'desc'];
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $schoolYears = SchoolYear::where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(6);
        $headers = [
            ['key' => 'id', 'label' => 'ID', 'class' => 'text-black'],
            ['key' => 'name', 'label' => 'Name', 'class' => 'text-black'],
            ['key' => 'start_year', 'label' => 'Start year', 'class' => 'text-black'],
            ['key' => 'end_year', 'label' => 'End year', 'class' => 'text-black'],
        ];
        return view('livewire.school-year-manage', [
            'schoolYears' => $schoolYears,
            'headers' => $headers,
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
        } else {
            $this->form->store();
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
    }
}
