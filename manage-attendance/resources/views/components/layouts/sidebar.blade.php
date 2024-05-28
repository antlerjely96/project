<x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

    {{-- BRAND --}}
    <x-app-brand class="p-5 pt-3" />

    {{-- MENU --}}
    <x-menu activate-by-route>

        {{-- User --}}
        @if($user = auth()->user())
            <x-menu-separator />

            <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover class="-mx-2 !-my-2 rounded">
                <x-slot:actions>
                    <x-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff" no-wire-navigate link="/logout" />
                </x-slot:actions>
            </x-list-item>

            <x-menu-separator />
        @endif

        <x-menu-item title="Home page" icon="o-building-storefront" link="/" />
{{--        <x-menu-sub title="Major Management" icon="o-cog-6-tooth">--}}
{{--            <x-menu-item title="Wifi" icon="o-sparkles" link="####" />--}}
{{--            <x-menu-item title="Archives" icon="o-archive-box" link="####" />--}}
{{--        </x-menu-sub>--}}
        <x-menu-item title="Major Management" icon="o-sparkles" link="{{ route('admin.majors') }}"></x-menu-item>
        <x-menu-item title="School year Management" icon="o-bookmark-square" link="{{ route('admin.school-years') }}"></x-menu-item>
        <x-menu-item title="Class Management" icon="o-users" link="{{ route('admin.classes') }}"></x-menu-item>
        <x-menu-item title="Student Management" icon="o-user-minus" link="{{ route('admin.students') }}"></x-menu-item>
        <x-menu-item title="Subject Management" icon="o-book-open" link="{{ route('admin.subjects') }}"></x-menu-item>
        <x-menu-item title="Instructor Management" icon="o-pencil" link="{{ route('admin.instructors') }}"></x-menu-item>
        <x-menu-item title="Division Management" icon="o-calendar-days" link="{{ route('admin.divisions') }}"></x-menu-item>
        <x-menu-item title="Attendance Management" icon="o-document-text" link="{{ route('admin.attendances') }}" id="attendance-menu"></x-menu-item>
{{--        <x-menu-item title="Personal Management" icon="o-user" link=""></x-menu-item>--}}
        <x-menu-item title="Sign out" icon="o-phone-x-mark" link="{{ route('logout') }}"></x-menu-item>
    </x-menu>
</x-slot:sidebar>
