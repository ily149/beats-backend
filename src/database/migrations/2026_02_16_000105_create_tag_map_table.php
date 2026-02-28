<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tag_map', function (Blueprint $table) {
            $table->foreignId('beat_id')
                ->constrained('beats')
                ->cascadeOnDelete();

            $table->foreignId('tag_id')
                ->constrained('tags')
                ->cascadeOnDelete();

            $table->primary(['beat_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tag_map');
    }
};
