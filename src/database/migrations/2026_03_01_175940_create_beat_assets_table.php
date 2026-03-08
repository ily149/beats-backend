<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('beat_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beat_license_id')->constrained()->cascadeOnDelete();

            $table->string('type'); // mp3 | wav | trackout_zip
            $table->string('disk')->default('s3');
            $table->string('path'); // ключ в MinIO
            $table->string('original_name')->nullable();
            $table->string('mime')->nullable();
            $table->unsignedBigInteger('size_bytes')->nullable();

            $table->timestamps();

            $table->unique(['beat_license_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beat_assets');
    }
};