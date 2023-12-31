<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teams List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <a href="{{ route('teams.create') }}"
                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                       {{ __('Add Team') }}
                    </a>

                    <table class="table-auto w-full">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">{{ __('Name') }}</th>
                            <th class="px-4 py-2">{{ __('Players') }}</th>
                            <th class="px-4 py-2">{{ __('Actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($teams as $team)
                            <tr>
                                <td class="border px-4 py-2">{{ $team->name }}</td>
                                <td class="border px-4 py-2">
                                    @foreach ($team->users as $player)
                                        {{ $player->name }} - <span class="italic">{{ __('positions.'.$player->pivot->position) }}</span>
                                        <br>
                                    @endforeach
                                </td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('teams.edit', $team->id) }}"
                                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ __('Edit') }}</a>
                                    <form action="{{ route('teams.destroy', $team->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                        >
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
