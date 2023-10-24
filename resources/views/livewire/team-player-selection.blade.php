<div>
    @foreach($players as $i => $user)
        <div class="mb-4 grid grid-cols-3 gap-4">
            <div>
                <label class="text-xl text-gray-600" for="players[{{ $i }}][id]">
                    {{ __('Player') }} #{{ $loop->iteration }}<span class="text-red-500">*</span>
                </label>
                <select
                    name="players[{{ $i }}][id]"
                    id="players[{{ $i }}][id]"
                    wire:model.live="players.{{ $i }}.id"
                    class="border-2 border-gray-300 p-2 w-full"
                >
                    <option value="">{{ __('Select Player') }}</option>
                    @foreach($users as $id => $name)
                        <option
                            value="{{ $id }}"
                            @disabled(in_array($id, collect($players)->filter(fn($value, $key) => $key != $i)->pluck('id')->toArray()))
                            @selected(old('players.'.$i.'.id') == $id)
                        >{{ $name }}</option>
                    @endforeach
                </select>
                @error('players.'.$i.'.id')
                    <div class="text-red-500 mt-2 text-sm">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div>
                <label class="text-xl text-gray-600" for="players[{{ $i }}][position]">
                    {{ __('Position') }}<span class="text-red-500">*</span>
                </label>
                <select
                    name="players[{{ $i }}][position]"
                    id="players[{{ $i }}][position]"
                    wire:model.live="players.{{ $i }}.position"
                    class="border-2 border-gray-300 p-2 w-full"
                >
                    <option value="">{{ __('Select Position') }}</option>
                    @foreach($positions as $id => $name)
                        <option
                            value="{{ $id }}"
                            @disabled(in_array($id, collect($players)->filter(fn($value, $key) => $key != $i)->pluck('position')->toArray()))
                            @selected(old('players.'.$i.'.position') == $id)
                        >{{ $name }}</option>
                    @endforeach
                </select>
                @error('players.'.$i.'.position')
                    <div class="text-red-500 mt-2 text-sm">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div>
                <button
                    wire:click.prevent="removeUser({{ $i }})"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mt-8"
                >
                    {{ __('Remove') }}
                </button>
            </div>
        </div>
    @endforeach

    @error('players')
        <div class="mb-4">
            <div class="text-red-500 mt-2 text-sm">
                {{ $message }}
            </div>
        </div>
    @enderror

    <button
        wire:click.prevent="addUser"
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4"
    >
        {{ __('Add Player') }}
    </button>
</div>
