<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Teams') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('teams.create') }}" class="cursor-pointer underline">{{ __('Add :name', ['name' => __('team')]) }}</a>

                    @if ($teams->isNotEmpty())
                        <div class="mb-4 min-w-full overflow-hidden overflow-x-auto mt-4">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600 dark:border-gray-600 border">
                                <thead>
                                    <tr class="bg-gray-50 dark:bg-gray-900">
                                        <th class="px-6 py-3 text-left min-w-44">
                                            <span class="text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Name') }}</span>
                                        </th>
                                        <th class="px-6 py-3 text-left min-w-44">
                                            <span class="text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Players') }}</span>
                                        </th>
                                        <th class="px-6 py-3 text-left min-w-44">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-600 divide-solid">
                                    @foreach($teams as $team)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5">
                                                {{ $team->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5">
                                                @foreach ($team->users as $player)
                                                    <ul class="list-disc">
                                                        <li>{{ $player->name }} - <span class="italic">{{ $player->pivot->position ? $player->pivot->position->name : '('.__('Not assigned').')' }}</span></li>
                                                    </ul>
                                                @endforeach
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5">
                                                <a href="{{ route('teams.edit', $team) }}" class="cursor-pointer underline">{{ __('Edit') }}</a>
                                                |
                                                <form method="POST"
                                                    class="inline-block"
                                                    action="{{ route('teams.destroy', $team) }}"
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
                        <div class="flex mt-4 justify-center text-center">
                            <span class=" text-gray-700 dark:text-gray-300">{{ __('There is not exists saved teams') }}</span>
                        </div>
                    @endif

                    <div class="mt-4">
                        {{ $teams->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
