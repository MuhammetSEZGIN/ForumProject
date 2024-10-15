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
        Schema::create('article__category', function (Blueprint $table) {
            $table->id();
            $table->foreignId("articleID")->constrained("articles", "articleID");
            $table->foreignId("categoryID")->constrained("categories", "categoryID");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('article__category');
    }
};
