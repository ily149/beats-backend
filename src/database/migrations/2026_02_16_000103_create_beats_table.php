<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('beats', function (Blueprint $table) {
            $table->id();

            $table->foreignId('genre_id')
                ->constrained('genres')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('name');
            $table->text('description')->nullable();

            // путь/ключ до файла (где лежит бит)
            $table->string('beat_location')->nullable();

            $table->decimal('price', 12, 2)->default(0);

            $table->timestamps();

            $table->index(['user_id', 'genre_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beats');
    }
};
