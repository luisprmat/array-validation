<?php

declare(strict_types=1);

namespace App\Models;

use LaravelLang\Models\Casts\TrimCast;
use LaravelLang\Models\Eloquent\Translation;

class TeamPositionTranslation extends Translation
{
    protected $fillable = [
        'locale',
        'name',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'name' => TrimCast::class,
        ];
    }
}
