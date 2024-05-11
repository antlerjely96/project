<?php

namespace App\Livewire;

use App\Livewire\Forms\MajorForm;
use App\Models\Major;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class MajorManage extends Component
{
    //    use pagination
    use WithPagination;
//    use Toast;
//    Major form
    public MajorForm $form;

    public string $title = 'Majors';
    public bool $editMode = false;
//    modal object
    public bool $majorModal = false;

    public string $search = '';

    public bool $drawer = false;
//    function to render the view
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $headers = [
            ['key' => 'id', 'label' => 'ID', 'class' => 'text-black'],
            ['key' => 'name', 'label' => 'Name', 'class' => 'text-black'],
        ];
        $sortBy = [
            'column' => 'id',
            'direction' => 'desc'
        ];
        $majors = Major::where('name', 'like', '%' . $this->search . '%')
                ->orderBy($sortBy['column'], $sortBy['direction'])
                ->paginate(6);
        return view('livewire.major-manage', [
            'majors' => $majors,
            'headers' => $headers,
            'sortBy' => $sortBy
        ]);
    }

//    function save data
    public function save(): void
    {
        /* if edit mode is true then update the data
            else store the data
        */
        if($this->editMode){
            //call the store function from the form
            $this->form->update();
        } else {
            //call the store function from the form
            $this->form->store();
        }
        //close the modal
        $this->majorModal = false;
    }

    //show information want edit in the modal
    public function edit($id): void
    {
        $major = Major::find($id);
        $this->form->setMajor($major);
        $this->editMode = true;
        $this->majorModal = true;
    }
//delete major
    public function delete($id): void
    {
        Major::find($id)->delete();
    }

    public function showModal(): void
    {
        $this->form->reset();
        $this->majorModal = true;
    }
}
