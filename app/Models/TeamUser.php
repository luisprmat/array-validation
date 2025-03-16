<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TeamUser extends Pivot
{
    public function position(): BelongsTo
    {
        return $this->belongsTo(TeamPosition::class, 'team_position_id');
    }

    public static function playersValidationMessages(): array
    {
        return [
            'players.required' => __('The player list cannot be empty.'),
            'players.min' => __('You must select at least :min :attribute.'),
            'players.max' => __('No more than :max :attribute can be selected.'),
            'players.*.id.required' => __('This player must be selected.'),
            'players.*.id.exists' => __('The selected player is invalid.'),
            'players.*.id.distinct' => __('Player cannot be selected twice.'),
            'players.*.position.required' => __('Player position is required.'),
            'players.*.position.distinct' => __('Player positions must be unique.'),
        ];
    }
}
