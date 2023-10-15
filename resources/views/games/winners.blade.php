<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Select Places') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('games.winners.update', $game->id) }}">
                        @csrf

                        @foreach($game->users as $user)
                            <div class="mb-4 grid grid-cols-2 gap-4">
                                <div class="w-1/2">{{ $user->name }}</div>
                                <div class="w-1/2">
                                    <select name="players[{{$user->id}}]" id="players[{{$user->id}}]"
                                            class="border-2 border-gray-300 p-2 w-full">
                                        <option value="">{{ __('Select Place') }}</option>
                                        @foreach($places as $place => $name)
                                            <option value="{{ $place }}" @selected(old('players.' . $user->id, $user->pivot->place) == $place)>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                    @error('players.'.$user->id)
                                    <div class="text-red-500 mt-2 text-sm">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        <div class="mb-4">
                            <button
                                type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded font-medium"
                            >
                                {{ __('Update Player Places') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
