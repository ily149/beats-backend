<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('media_assets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('beat_id')
                ->nullable()
                ->constrained('beats')
                ->cascadeOnDelete();

            $table->string('picture_profile')->nullable();
            $table->string('beat_picture')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'beat_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_assets');
    }
};
