<div class="p-6 text-gray-900 dark:text-gray-100">
    <button class="cursor-pointer underline" wire:click="addPosition">{{ __('Add :name', ['name' => __('position')]) }}</button>

    @if ($positions->isNotEmpty())
        <div class="mb-4 min-w-full overflow-hidden overflow-x-auto mt-4">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600 dark:border-gray-600 border">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-900">
                        @foreach ($locales as $locale)
                            <th class="px-6 py-3 text-left">
                                <span class="text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ $locale->localized }}</span>
                            </th>
                        @endforeach
                        <th class="px-6 py-3 text-left">
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600 divide-solid">
                    @foreach($positions as $position)
                        <tr wire:key="row-{{ $position->id }}">
                            @foreach ($locales as $locale)
                                @if (in_array($position->id, $editingPositions))
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5" wire:key="cell-{{ $locale->code }}-{{ $position->id }}-input">
                                        <x-text-input wire:model="selectedPositions.{{ $position->id }}.{{ $locale->code }}" class="text-sm" />
                                        <x-input-error :messages="$errors->get('selectedPositions.'.$position->id.'.'.$locale->code)" class="mt-1 text-xs" />
                                    </td>
                                @else
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5" wire:key="cell-{{ $locale->code }}-{{ $position->id }}">
                                        {{ $position->getTranslation('name', $locale) }}
                                    </td>
                                @endif
                            @endforeach
                            @if (in_array($position->id, $editingPositions))
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5" wire:key="cell-{{ $position->id }}-saving">
                                    <button wire:loading.class="opacity-50" wire:loading.attr="disabled" wire:click="save({{ $position->id }})" class="cursor-pointer underline">{{ __('Save') }}</button>
                                    |
                                    <button wire:click="cancelEditing({{ $position->id }})" class="text-gray-500 dark:text-gray-400 cursor-pointer underline">{{ __('Cancel') }}</button>
                                </td>
                            @else
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5" wire:key="cell-{{ $position->id }}-editing">
                                    <button wire:click="editPosition({{ $position->id }})" class="cursor-pointer underline">{{ __('Edit') }}</button>
                                    |
                                    <button
                                        wire:click="delete({{ $position->id }})"
                                        wire:confirm="{{ __('Are you sure you want to delete this team position?') }}"
                                        class="text-red-500 dark:text-red-400 cursor-pointer underline"
                                    >
                                        {{ __('Delete') }}
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    @if ($isNewPosition)
                        <tr wire:key="row-new">
                            @foreach ($locales as $locale)
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5" wire:key="cell-{{ $locale->code }}-newInput">
                                    <x-text-input wire:model="newPosition.{{ $locale->code }}" class="text-sm" />
                                    <x-input-error :messages="$errors->get('newPosition.'.$locale->code)" class="mt-1 text-xs" />
                                </td>
                            @endforeach
                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5" wire:key="cell-newPosition-saving">
                                <button wire:loading.class="opacity-50" wire:loading.attr="disabled" wire:click="saveNewPosition" class="cursor-pointer underline">{{ __('Save') }}</button>
                                |
                                <button wire:click="cancelCreating" class="text-gray-500 dark:text-gray-400 cursor-pointer underline">{{ __('Cancel') }}</button>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    @else
        <div class="flex mt-4 justify-center text-center">
            <span class=" text-gray-700 dark:text-gray-300">{{ __('There is not exists saved positions') }}</span>
        </div>
    @endif

    {{-- <div class="mt-4">
        {{ $positions->links() }}
    </div> --}}
</div>
