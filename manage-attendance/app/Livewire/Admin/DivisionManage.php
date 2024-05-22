<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\Admin\DivisionForm;
use App\Models\ClassStudent;
use App\Models\Division;
use App\Models\DivisionDetails;
use App\Models\Instructor;
use App\Models\Major;
use App\Models\SchoolYear;
use App\Models\Subject;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class DivisionManage extends Component
{
    use WithPagination;
    use Toast;
    public string $title = 'Divisions';
    public array $sortBy = [
        'column' => 'id',
        'direction' => 'desc'
    ];
    public array $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'text-black'],
        ['key' => 'classStudent.name', 'label' => 'Class name', 'class' => 'text-black'],
        ['key' => 'subject.name', 'label' => 'Subject name', 'class' => 'text-black'],
        ['key' => 'instructor.name', 'label' => 'Instructor name', 'class' => 'text-black'],
        ['key' => 'admin.name', 'label' => 'Divided by', 'class' => 'text-black'],
        ['key' => 'start_date', 'label' => 'Start at', 'class' => 'text-black'],
        ['key' => 'status', 'label' => 'Status', 'class' => 'text-black'],
    ];
    public $selectedMajor = null;
    public $selectedSchoolYear = null;
    public $selectedClass = null;
    public $selectedSubject = null;
    public $selectedInstructor = null;
    public bool $divisionTable = false;
    public bool $createDivisionModal = false;
    public DivisionForm $form;
    public bool $viewDetailDivisionModal = false;
    public bool $editDivisionModal = false;
    public bool $editMode = false;
    public $divisionDetails = [];
    public array $headersDetail = [
        ['key' => 'day_of_week', 'label' => 'Day of week', 'class' => 'text-black'],
        ['key' => 'division_date', 'label' => 'Division date', 'class' => 'text-black'],
        ['key' => 'division_start_time', 'label' => 'Start time', 'class' => 'text-black'],
        ['key' => 'division_end_time', 'label' => 'End time', 'class' => 'text-black'],
    ];

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

    #[Computed]
    public function divisions(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $this->divisionTable = true;
        return Division::with('classStudent')
            ->where('class_student_id', $this->selectedClass)
            ->paginate(4);
    }

    #[Computed]
    public function subjects()
    {
        return Subject::where('major_id', $this->selectedMajor)
                        ->whereNotIn('id', function($query) {
                            $query->select('subject_id')
                                ->from('divisions')
                                ->where('class_student_id', $this->selectedClass);
                        })->get();
    }

    #[Computed]
    public function instructors(){
        return Instructor::where('major_id', $this->selectedMajor)
                            ->get();
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.admin.division-manage', [
            'majors' => $this->majors(),
            'schoolYears' => $this->schoolYears(),
        ]);
    }

    public function handleClassChange(){
        if ($this->selectedClass == 0) {
            $this->divisionTable = false;
        } else {
            $this->divisionTable = true;
        }
    }

    public function showModal(): void
    {
        $this->form->reset();
        $this->createDivisionModal = true;
    }

    public function save(): void
    {
        if($this->editMode){
            $this->form->update();
            $this->editMode = false;
            $this->editDivisionModal = false;
            $this->success('Division updated successfully');
        } else {
            Division::create([
                'class_student_id' => $this->selectedClass,
                'admin_id' => session()->get('user')->id,
                'subject_id' => $this->selectedSubject,
                'instructor_id' => $this->selectedInstructor,
                'start_date' => $this->form->start_date,
                'status' => 'Open',
            ]);

            $division_id = Division::where('class_student_id', $this->selectedClass)
                ->where('subject_id', $this->selectedSubject)
                ->first()
                ->id;

            $count = 0;
            $duration = Subject::where('id', $this->selectedSubject)->first()->duration;
            $startDate = Carbon::createFromFormat('Y-m-d', $this->form->start_date);
            while($count < ceil($duration / $this->form->time_day)){
                foreach ($this->form->start_time as $key => $value){
                    if($startDate->dayOfWeekIso == $key){
//                        dd($key);
//                        dd($startDate->dayName);
//                        dd($value);
                        DivisionDetails::create([
                            'division_id' => $division_id,
                            'day_of_week' => $startDate->dayName,
                            'division_date' => $startDate->format('Y-m-d'),
                            'division_start_time' => Carbon::createFromFormat('H:i', $value),
                            'division_end_time' => Carbon::createFromFormat('H:i', $value)->addHours($this->form->time_day)->format('H:i'),
                        ]);
                        $count++;
                    }
                }
                $startDate->addDay();
            }
            $this->createDivisionModal = false;
            $this->success('Division created successfully');
        }
    }

    public function edit($id): void
    {
        $division = Division::find($id);
        $this->form->setInstructorId($division);
        $this->editMode = true;
        $this->editDivisionModal = true;
    }

    public function viewDetail($id){
        $this->divisionDetails = DivisionDetails::where('division_id', $id)->get()->toArray();
        $this->viewDetailDivisionModal = true;
    }

    public function changeStatus($id): void
    {
        if(Division::find($id)->status == 'Open'){
            Division::where('id', $id)->update(['status' => 'Close']);
            $this->success('Closed division');
        } else {
            Division::where('id', $id)->update(['status' => 'Open']);
            $this->success('Opened division');
        }
    }

    public function delete($id): void
    {
        Division::find($id)->delete();
        $this->success('Division deleted successfully');
    }
}
