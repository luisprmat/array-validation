<?php

namespace App\Livewire;

use App\Models\Team;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Component;

class TeamPlayerSelection extends Component
{
    // Team property used for Edit
    public ?Team $team = null;

    // Public array of users for our select dropdown
    public array $users = [];

    // Public array of positions for our select dropdown
    public array $positions = [];

    // These are the players we are going to save. We'll use this in our validation rules
    #[Rule([
        'players' => ['required', 'array', 'min:3', 'max:10'],
        'players.*.id' => ['required', 'exists:users,id', 'integer', 'distinct'],
        'players.*.position' => ['required', 'string', 'max:200', 'distinct'],
    ], message: [
        'players.*.id.required' => 'Player #:position must be selected.',
        'players.*.id.exists' => 'The selected player is invalid.',
        'players.*.id.distinct' => 'Player cannot be selected twice.',
        'players.*.position.required' => 'Player position is required',
        'players.*.position.distinct' => 'Player positions must be unique.',
    ])]
    public array $players = [];

    // This is the template for a new user with empty defaults
    public array $userTemplate = [
        'user_id' => '',
        'position' => '',
    ];

    // On update, we want to re-validate the whole component
    public function updated($propertyName)
    {
        $this->validate();
    }

    public function mount()
    {
        // We load all users in the select dropdown
        $this->users = User::pluck('name', 'id')->toArray();

        $this->positions = $this->getPositions();

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
                    'position' => $player->pivot->position,
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

    private function getPositions(): array
    {
        return [
            'goalkeeper' => __('positions.goalkeeper'),
            'defender' => __('positions.defender'),
            'midfielder' => __('positions.midfielder'),
            'forward' => __('positions.forward'),
            'coach' => __('positions.coach'),
            'assistant_coach' => __('positions.assistant_coach'),
            'physiotherapist' => __('positions.physiotherapist'),
            'doctor' => __('positions.doctor'),
            'manager' => __('positions.manager'),
            'president' => __('positions.president'),
        ];
    }
}
