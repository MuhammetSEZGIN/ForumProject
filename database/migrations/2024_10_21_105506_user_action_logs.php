<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('userActionLogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userID')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('action')->nullable();
            $table->ipAddress('ip');
            $table->string('userAgent');
            $table->json('postData');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('userActionLogs');

    }
};
