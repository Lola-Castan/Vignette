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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image');
            $table->string('music');
            $table->string('video');
            $table->text('description'); 
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('card_size_id')->constrained('card_sizes');
            $table->boolean('deleted')->default(false);
            // todo owner
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
