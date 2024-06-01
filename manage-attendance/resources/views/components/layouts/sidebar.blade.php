<x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

    {{-- BRAND --}}
    <x-app-brand class="p-5 pt-3" />

    {{-- MENU --}}
    <x-menu activate-by-route>
        @if(Auth::guard('login')->user()->role == 1)
{{--            <x-menu-item title="Home page" icon="o-building-storefront" link="/" />--}}
            <x-menu-item title="Major Management" icon="o-sparkles" link="{{ route('admin.majors') }}"></x-menu-item>
            <x-menu-item title="School year Management" icon="o-bookmark-square" link="{{ route('admin.school-years') }}"></x-menu-item>
            <x-menu-item title="Class Management" icon="o-users" link="{{ route('admin.classes') }}"></x-menu-item>
            <x-menu-item title="Student Management" icon="o-user-minus" link="{{ route('admin.students') }}"></x-menu-item>
            <x-menu-item title="Subject Management" icon="o-book-open" link="{{ route('admin.subjects') }}"></x-menu-item>
            <x-menu-item title="Instructor Management" icon="o-pencil" link="{{ route('admin.instructors') }}"></x-menu-item>
            <x-menu-item title="Division Management" icon="o-calendar-days" link="{{ route('admin.divisions') }}"></x-menu-item>
            <x-menu-item title="Attendance Management" icon="o-document-text" link="{{ route('admin.attendances') }}" id="attendance-menu"></x-menu-item>
            <x-menu-item title="Personal Management" icon="o-cog-6-tooth" link="{{ route('admin.admins') }}"></x-menu-item>
        @elseif(Auth::guard('login')->user()->role == 2)
            <x-menu-item title="Attendance Management" icon="o-document-text" link="{{ route('instructor.attendances') }}" id="attendance-menu-instructor"></x-menu-item>
            <x-menu-item title="Personal Management" icon="o-cog-6-tooth" link="{{ route('instructor.instructors') }}"></x-menu-item>
        @endif
{{--        <x-menu-item title="Personal Management" icon="o-user" link=""></x-menu-item>--}}
        <x-menu-item title="Sign out" icon="o-phone-x-mark" link="{{ route('logout') }}"></x-menu-item>
    </x-menu>
</x-slot:sidebar>
