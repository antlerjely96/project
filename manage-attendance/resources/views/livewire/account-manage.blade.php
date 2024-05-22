<div>
    {{-- Success is as dangerous as failure. --}}
    <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" />
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your account</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <x-form wire:submit="login">
                <div>
                    <div class="mt-2">
                        <x-input label="Email" wire:model="form.email" type="email"/>
                    </div>
                </div>
                <div>
                    <div class="mt-2">
                        <x-input label="Password" wire:model="form.password" type="password"/>
                    </div>
                </div>
                <div>
                    <x-button label="Sign in" class="btn-primary flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" type="submit"/>
                </div>
            </x-form>
        </div>
    </div>
</div>
