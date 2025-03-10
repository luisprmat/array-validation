<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create :name', ['name' => __('game')]) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('games.store') }}" class="space-y-6">
                    @csrf
                    <div class="max-w-xl">
                        <x-input-label for="name" :value="__('Game\'s name')" :required="true" />
                        <x-text-input name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div class="font-medium text-sm text-gray-700 dark:text-gray-300">
                        {{ __('Select players') }}
                        <span class="text-red-500">*</span>
                    </div>

                    <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($users as $id => $name)
                            <div class="w-full">
                                <label class="inline-flex items-center">
                                    <input
                                        type="checkbox"
                                        class="rounded-sm dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-xs focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                        name="players[]"
                                        value="{{ $id }}"
                                        @checked(in_array($id, old('players', [])))
                                    >
                                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-300">{{ $name }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-4">
                        <x-input-error class="mt-2" :messages="$errors->get('players')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save :name', ['name' => __('game')]) }}</x-primary-button>

                        @if (session('status') === 'game-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600 dark:text-gray-400"
                            >{{ __('Saved.') }}</p>
                        @endif
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
