<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class AttendanceManage extends Component
{
    public string $title = 'Attendances';
    public string $search = '';

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.admin.attendance-manage');
    }
}
