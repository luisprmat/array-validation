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

                    <div class="grid grid-cols-1 gap-y-4 gap-x-8 divide-y sm:divide-y-0 divide-gray-300 dark:divide-gray-700">
                        @foreach($team->users as $player)
                            <div class="space-y-1 sm:space-y-0 sm:grid sm:grid-cols-2 gap-4 items-center">
                                <div>
                                    <x-input-label for="players[{{ $player->id }}][id]" :value="__('Player')" :required="true" />
                                    <x-select-input name="players[{{ $player->id }}][id]" id="players[{{ $player->id }}][id]" class="w-full md:w-3/4 mt-1">
                                        <option value="">{{ __('Select :name', ['name' => __('Player')]) }}</option>
                                        @foreach($users as $id => $name)
                                            <option value="{{ $id }}" @selected(old('players.'.$player->id.'.id', $player->id) == $id)>{{ $name }}</option>
                                        @endforeach
                                    </x-select-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('players.'.$player->id.'.id')" />
                                </div>
                                <div class="mb-4 sm:mb-0">
                                    <x-input-label for="players[{{ $player->id }}][position]" :value="__('Position')" :required="true" />
                                    <x-select-input name="players[{{ $player->id }}][position]" id="players[{{ $player->id }}][position]" class="w-full md:w-3/4 mt-1">
                                        <option value="">{{ __('Select :name', ['name' => __('Position')]) }}</option>
                                        @foreach($positions as $position)
                                            <option value="{{ $position->id }}" @selected(old('players.'.$player->id.'.position', $player->pivot->team_position_id) == $position->id)>{{ $position->name }}</option>
                                        @endforeach
                                    </x-select-input>
                                    <x-input-error class="mt-2" :messages="$errors->get('players.'.$player->id.'.position')" />
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-4">
                        <x-input-error class="mt-2" :messages="$errors->get('players')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Update :name', ['name' => __('team')]) }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
