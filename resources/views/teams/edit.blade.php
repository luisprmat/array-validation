<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit :name', ['name' => __('team')]) }}: <span class="italic">{{ $team->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('teams.update', $team) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="max-w-xl">
                        <x-input-label for="name" :value="__('Team\'s name')" :required="true" />
                        <x-text-input name="name" type="text" class="mt-1 block w-full" :value="old('name', $team->name)" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <livewire:team-player-selection :team="$team" />

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Update :name', ['name' => __('team')]) }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
