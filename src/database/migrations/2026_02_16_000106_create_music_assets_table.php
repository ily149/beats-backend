<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('music_assets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('beat_id')
                ->constrained('beats')
                ->cascadeOnDelete();

            $table->boolean('beat_exclusive')->default(false);
            $table->boolean('beat_premium')->default(false);
            $table->boolean('beat_basic')->default(true);

            $table->timestamps();

            $table->index('beat_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('music_assets');
    }
};
