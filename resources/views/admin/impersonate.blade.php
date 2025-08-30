<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Impersonate user</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.impersonate.store') }}">
                    @csrf
                    <div>
                        <x-input-label for="username" value="Username" />
                        <x-text-input id="username" name="username" type="text" class="mt-1 block w-full"
                                      value="{{ old('username') }}" required autofocus />
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>
                    <div class="mt-6">
                        <x-primary-button>Impersonate</x-primary-button>
                        <a href="{{ route('dashboard') }}" class="ms-3 underline text-sm">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
