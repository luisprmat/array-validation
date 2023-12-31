<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Game') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('games.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="text-xl text-gray-600" for="name">
                                {{ __('Name') }}<span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                class="border-2 border-gray-300 p-2 w-full"
                                name="name"
                                id="name"
                                value="{{ old('name') }}"
                            >
                            @error('name')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="text-xl text-gray-600">
                            {{ __('Players') }}<span class="text-red-500">*</span>
                        </div>
                        <div class="my-4 grid grid-cols-2 gap-4">
                            @foreach($users as $id => $name)
                                <div class="w-1/2">
                                    <label class="text-xl text-gray-600">
                                        <input
                                            type="checkbox"
                                            class="border-2 border-gray-300 p-2"
                                            name="players[]"
                                            id="players"
                                            value="{{ $id }}" @checked(in_array($id, old('players', [])))
                                        >
                                        {{ $name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="mb-4">
                            @error('players')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded font-medium">
                                {{ __('Create Game') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
