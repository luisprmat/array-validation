<?php

namespace App\Livewire;

use App\Models\Team;
use App\Models\TeamPosition;
use App\Models\TeamUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;

class TeamPlayerSelection extends Component
{
    // Team property used for Edit
    public ?Team $team = null;

    // Public array of users for our select dropdown
    public array $users = [];

    // Public array of positions for our select dropdown
    public Collection $positions;

    public array $players = [];

    // This is the template for a new user with empty defaults
    public array $userTemplate = [
        'user_id' => '',
        'position' => '',
    ];

    protected function rules(): array
    {
        return [
            'players' => ['required', 'array', 'min:3', 'max:10'],
            'players.*.id' => ['required', 'exists:users,id', 'integer', 'distinct'],
            'players.*.position' => ['required', 'integer', 'max:200', 'distinct', Rule::exists('team_positions', 'id')],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return TeamUser::playersValidationMessages();
    }

    // On update, we want to re-validate the whole component
    public function updated()
    {
        $this->validate();
    }

    public function mount()
    {
        // We load all users in the select dropdown
        $this->users = User::pluck('name', 'id')->toArray();

        $this->positions = TeamPosition::all();

        // If we have any old input, we'll load it into our players' array
        if (count(old('players', [])) > 0) {
            foreach (old('players', []) as $index => $player) {
                $this->players[$index] = [
                    'id' => $player['id'],
                    'position' => $player['position'],
                ];
            }
        } elseif ($this->team) {
            // Otherwise, if we are editing a team, we'll load the players from the database
            $this->team->load(['users']);
            foreach ($this->team->users as $index => $player) {
                $this->players[$index] = [
                    'id' => $player->id,
                    'position' => $player->pivot->team_position_id,
                ];
            }
        }
    }

    public function render()
    {
        return view('livewire.team-player-selection');
    }

    // This adds a new line to our players' array and re-validates the component
    public function addUser(): void
    {
        $this->players[] = $this->userTemplate;
        $this->validate();
    }

    // This removes a line from our players' array and re-validates the component
    public function removeUser($index)
    {
        unset($this->players[$index]);
        $this->validate();
    }
}
