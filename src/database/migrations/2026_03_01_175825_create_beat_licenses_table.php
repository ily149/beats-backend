<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('beat_licenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beat_id')->constrained()->cascadeOnDelete();

            $table->string('code'); // base | premium | exclusive
            $table->decimal('price', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(['beat_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beat_licenses');
    }
};
