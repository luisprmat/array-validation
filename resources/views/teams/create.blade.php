<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Select :name', ['name' => __('team')]) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('teams.store') }}" class="space-y-6">
                    @csrf
                    <div class="max-w-xl">
                        <x-input-label for="name" :value="__('Team\'s name')" :required="true" />
                        <x-text-input name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div class="grid grid-cols-1 gap-y-4 gap-x-8 divide-y sm:divide-y-0 divide-gray-300 dark:divide-gray-700">
                        @for($i = 1; $i <= 3; $i++)
                            <div class="space-y-1 sm:space-y-0 sm:grid sm:grid-cols-2 gap-4 items-center">
                                <div>
                                    <x-input-label for="players[{{ $i }}][id]" :value="__('Player')" :required="true" />
                                    <x-select-input name="players[{{ $i }}][id]" id="players[{{ $i }}][id]" class="w-full md:w-3/4 mt-1">
                                        <option value="">{{ __('Select :name', ['name' => __('Player')]) }}</option>
                                        @foreach($users as $id => $name)
                                            <option value="{{ $id }}" @selected(old('players.'.$i.'.id') == $id)>{{ $name }}</option>
                                        @endforeach
                                    </x-select-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('players.'.$i.'.id')" />
                                </div>
                                <div class="mb-4 sm:mb-0">
                                    <x-input-label for="players[{{ $i }}][position]" :value="__('Position')" :required="true" />
                                    <x-select-input name="players[{{ $i }}][position]" id="players[{{ $i }}][position]" class="w-full md:w-3/4 mt-1">
                                        <option value="">{{ __('Select :name', ['name' => __('Position')]) }}</option>
                                        @foreach($positions as $id => $name)
                                            <option value="{{ $id }}" @selected(old('players.'.$i.'.position') == $id)>{{ $name }}</option>
                                        @endforeach
                                    </x-select-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('players.'.$i.'.position')" />
                                </div>
                            </div>
                        @endfor
                    </div>

                    <div class="mb-4">
                        <x-input-error class="mt-2" :messages="$errors->get('players')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Create :name', ['name' => __('team')]) }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
