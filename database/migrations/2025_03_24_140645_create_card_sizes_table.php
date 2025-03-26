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
        Schema::create('card_sizes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // todo question Erwann : pourquoi name n'a pas besoin de default value ?
            $table->integer('width')->default(1);
            $table->integer('height')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_sizes');
    }
};
