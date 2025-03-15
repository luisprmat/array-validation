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
}
