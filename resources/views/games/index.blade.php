<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Games') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('games.create') }}" class="cursor-pointer underline">{{ __('Add :name', ['name' => __('game')]) }}</a>

                    @if ($games->isNotEmpty())
                        <div class="mb-4 min-w-full overflow-hidden overflow-x-auto mt-4">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600 dark:border-gray-600 border">
                                <thead>
                                    <tr class="bg-gray-50 dark:bg-gray-900">
                                        <th class="px-6 py-3 text-left">
                                            <span class="text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Name') }}</span>
                                        </th>
                                        <th class="px-6 py-3 text-left">
                                            <span class="text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Players') }}</span>
                                        </th>
                                        <th class="px-6 py-3 text-left">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-600 divide-solid">
                                    @foreach($games as $game)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5">
                                                {{ $game->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5">
                                                @foreach ($game->users as $player)
                                                    {{ $player->name }}<br>
                                                @endforeach
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5">
                                                <a href="{{ route('games.edit', $game) }}" class="cursor-pointer underline">{{ __('Edit') }}</a>
                                                |
                                                <form method="POST"
                                                    class="inline-block"
                                                    action="{{ route('games.destroy', $game) }}"
                                                    onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="text-red-500 dark:text-red-400 cursor-pointer underline">{{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="flex justify-center text-center">
                            <span class=" text-gray-700 dark:text-gray-300">{{ __('There is not exists saved games') }}</span>
                        </div>
                    @endif

                    <div class="mt-4">
                        {{ $games->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
