<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div>You are logged in.</div>

                @if (auth()->user()->is_admin && !session()->has('impersonator_id'))
                    <div class="mt-6">
                        <a href="{{ route('admin.impersonate.create') }}" class="underline">Impersonate a user</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
