<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beats', function (Blueprint $table) {
            $table->unsignedSmallInteger('bpm')->nullable()->after('description');
            $table->string('key', 50)->nullable()->after('bpm');
        });
    }

    public function down(): void
    {
        Schema::table('beats', function (Blueprint $table) {
            $table->dropColumn(['bpm', 'key']);
        });
    }
};
