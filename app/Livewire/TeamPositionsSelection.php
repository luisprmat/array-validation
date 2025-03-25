<?php

namespace App\Livewire;

use App\Models\TeamPosition;
use Illuminate\Database\Eloquent\Collection;
use LaravelLang\Locales\Facades\Locales;
use Livewire\Component;

class TeamPositionsSelection extends Component
{
    public Collection $positions;

    public bool $isNewPosition = false;

    public array $editingPositions = [];

    public array $selectedPositions = [];

    public array $newPosition;

    public function positionTemplate(): array
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

    protected function rules(): array
    {
        return [];
    }

    public function addPosition()
    {
        $this->newPosition = $this->positionTemplate();
        $this->isNewPosition = true;
    }

    public function saveNewPosition()
    {
        TeamPosition::create(['name' => $this->newPosition]);

        $this->isNewPosition = false;

        $this->positions = TeamPosition::all();
    }

    public function cancelCreating()
    {
        $this->newPosition = [];
        $this->isNewPosition = false;
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
    }

    public function save(TeamPosition $position)
    {
        $locales = Locales::installed();

        foreach ($locales as $locale) {
            $position->setTranslation('name', $this->selectedPositions[$position->id][$locale->code], $locale);
        }

        $position->save();
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
