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
        Schema::create('reportedArticles', function (Blueprint $table) {
            $table->id();
            $table->string('reason');
            $table->foreignId('articleID')->constrained('articles', 'articleID')->onDelete('cascade');
            $table->foreignId('userID')->constrained('users', 'id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('reportedArticles');
    }
};
