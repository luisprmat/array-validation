<?php

namespace App\Livewire;

use App\Models\TeamPosition;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use LaravelLang\Locales\Facades\Locales;
use Livewire\Component;

class TeamPositionsSelection extends Component
{
    public Collection $positions;

    public bool $isNewPosition = false;

    public array $editingPositions = [];

    public array $selectedPositions = [];

    public array $newPosition;

    private function positionTemplate(): array
    {
        $locales = Locales::installed();

        $template = [];

        foreach ($locales as $locale) {
            $template[$locale->code] = '';
        }

        return $template;
    }

    public function mount()
    {
        $this->positions = TeamPosition::all();
    }

    protected function messages()
    {
        $locales = Locales::installed();

        $translationsMessages = [];

        foreach ($locales as $locale) {
            $translationsMessages['newPosition.'.$locale->code.'.required'] = __('There must be a translation for :locale.', ['locale' => $locale->localized]);
            $translationsMessages['selectedPositions.*.'.$locale->code.'.required'] = __('There must be a translation for :locale.', ['locale' => $locale->localized]);
            $translationsMessages['newPosition.'.$locale->code.'.unique'] = __('This position already exists with :locale translation.', ['locale' => $locale->localized]);
            $translationsMessages['selectedPositions.*.'.$locale->code.'.unique'] = __('This position already exists with :locale translation.', ['locale' => $locale->localized]);
        }

        return $translationsMessages;
    }

    public function addPosition()
    {
        $this->newPosition = $this->positionTemplate();
        $this->isNewPosition = true;
    }

    public function saveNewPosition()
    {
        $locales = Locales::installed();
        $staticRules = ['newPosition' => 'required'];
        $dynamicRules = [];

        foreach ($locales as $locale) {
            $dynamicRules['newPosition.'.$locale->code] = [
                'required',
                Rule::unique('team_position_translations', 'name')
                    ->where(fn ($query) => $query->where('locale', $locale->code)),
            ];
        }

        $this->validate(array_merge($staticRules, $dynamicRules));

        TeamPosition::create(['name' => $this->newPosition]);

        $this->isNewPosition = false;
        $this->resetValidation(['newPosition', 'newPosition.*']);

        $this->positions = TeamPosition::all();
    }

    public function cancelCreating()
    {
        $this->newPosition = [];
        $this->isNewPosition = false;
        $this->resetValidation(['newPosition', 'newPosition.*']);
    }

    public function editPosition(TeamPosition $position)
    {
        $locales = Locales::installed();

        $this->editingPositions[] = $position->id;

        $selectedPosition = [];

        foreach ($locales as $locale) {
            $selectedPosition[$locale->code] = $position->getTranslation('name', $locale);
        }

        $this->selectedPositions[$position->id] = $selectedPosition;
    }

    public function cancelEditing(TeamPosition $position)
    {
        $this->editingPositions = array_diff($this->editingPositions, [$position->id]);
        unset($this->selectedPositions[$position->id]);
        $this->resetErrorBag();
    }

    public function save(TeamPosition $position)
    {
        $locales = Locales::installed();

        $staticRules = ['selectedPositions' => 'required'];
        $dynamicRules = [];
        foreach ($locales as $locale) {
            $dynamicRules['selectedPositions.*.'.$locale->code] = [
                'required',
                Rule::unique('team_position_translations', 'name')
                    ->ignore($position->id, 'item_id')
                    ->where(fn ($query) => $query->where('locale', $locale->code)),
            ];
        }

        $this->validate(array_merge($staticRules, $dynamicRules));
        foreach ($locales as $locale) {
            $position->setTranslation('name', $this->selectedPositions[$position->id][$locale->code], $locale);
        }

        $position->save();
        $this->resetErrorBag();
        $this->editingPositions = array_diff($this->editingPositions, [$position->id]);
        unset($this->selectedPositions[$position->id]);
        $this->positions = TeamPosition::all();
    }

    public function delete(TeamPosition $position)
    {
        $position->delete();
        $this->positions = TeamPosition::all();
    }

    public function render()
    {
        return view('livewire.team-positions-selection', [
            'locales' => Locales::installed(),
        ]);
    }
}
