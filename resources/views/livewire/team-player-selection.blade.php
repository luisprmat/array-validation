<div>
    <h3 class="font-bold text-gray-700 dark:text-gray-300">{{ __('Players') }}:</h3>
    <div class="grid grid-cols-1 gap-y-4 gap-x-8 divide-y sm:divide-y-0 divide-gray-300 dark:divide-gray-700">
        @foreach($players as $i => $user)
            <div class="space-y-1 sm:space-y-0 sm:grid sm:grid-cols-[1fr_1fr_auto] gap-4 first:mt-4">
                <div>
                    <x-input-label for="players[{{ $i }}][id]" :value="__('Player')" :required="true" />
                    <x-select-input
                        name="players[{{ $i }}][id]"
                        id="players[{{ $i }}][id]"
                        wire:model.change="players.{{$i}}.id"
                        class="w-full md:w-3/4 mt-1"
                    >
                        <option value="">{{ __('Select :name', ['name' => __('Player')]) }}</option>
                        @foreach($users as $id => $name)
                            <option
                                value="{{ $id }}"
                                @disabled(in_array($id, collect($players)->filter(fn($value, $key) => $key != $i)->pluck('id')->toArray()))
                                @selected(old('players.'.$i.'.id') == $id)
                            >{{ $name }}</option>
                        @endforeach
                    </x-select-input>
                    <x-input-error class="mt-2" :messages="$errors->get('players.'.$i.'.id')" />
                </div>
                <div class="mb-4 sm:mb-0">
                    <x-input-label for="players[{{ $i }}][position]" :value="__('Position')" :required="true" />
                    <x-select-input
                        name="players[{{ $i }}][position]"
                        id="players[{{ $i }}][position]"
                        wire:model.change="players.{{ $i }}.position"
                        class="w-full md:w-3/4 mt-1"
                    >
                        <option value="">{{ __('Select :name', ['name' => __('Position')]) }}</option>
                        @foreach($positions as $position)
                            <option
                                value="{{ $position->id }}"
                                @disabled(in_array($position->id, collect($players)->filter(fn($value, $key) => $key != $i)->pluck('position')->toArray()))
                                @selected(old('players.'.$i.'.position') == $position->id)
                            >{{ $position->name }}</option>
                        @endforeach
                    </x-select-input>
                    <x-input-error class="mt-2" :messages="$errors->get('players.'.$i.'.position')" />
                </div>
                <div class="mb-4 sm:mb-0 self-end justify-self-end">
                    <x-danger-button type="button" wire:click.prevent="removeUser({{ $i }})">{{ __('Remove') }}</x-danger-button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mb-4">
        <x-input-error class="mt-2" :messages="$errors->get('players')" />
    </div>

    <x-primary-button type="button" wire:click.prevent="addUser">
        {{ __('Add :name', ['name' => __('Player')]) }}
    </x-primary-button>
</div>
