<?php

declare(strict_types=1);

use App\Models\TeamPosition;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_position_translations', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(TeamPosition::class, 'item_id')
                ->constrained('team_positions')
                ->cascadeOnDelete();

            $table->string('locale');

            $table->string('name')->nullable();

            $table->unique(['item_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_position_translations');
    }
};
