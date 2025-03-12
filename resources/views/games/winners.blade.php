<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Select places for players in the game ":game"', ['game' => $game->name]) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('games.winners.update', $game) }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-y-4 gap-x-8 divide-y sm:divide-y-0 divide-gray-300 dark:divide-gray-700">
                        @foreach($game->users as $user)
                            <div class="flex flex-col">
                                <div class="space-y-1 sm:space-y-0 sm:grid sm:grid-cols-2 gap-4 items-center">
                                    <div class="w-full font-medium text-gray-700 dark:text-gray-300">{{ $user->name }}</div>
                                    <div class="w-full mb-2 sm:mb-0">
                                        <x-select-input
                                            name="players[{{$user->id}}]"
                                            id="players[{{$user->id}}]"
                                            class="w-full"
                                        >
                                            <option value="">{{ __('Select Place') }}</option>
                                            @foreach($places as $place => $name)
                                                <option value="{{ $place }}" @selected(old('players.' . $user->id, $user->pivot->place) == $place)>{{ $name }}</option>
                                            @endforeach
                                        </x-select-input>
                                    </div>
                                </div>
                                <x-input-error class="mb-1 sm:mt-2 mr-0 ml-auto" :messages="$errors->get('players.'.$user->id)" />
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-4">
                        <x-input-error class="mt-2" :messages="$errors->get('players')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Update Player Places') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
