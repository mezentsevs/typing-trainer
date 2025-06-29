<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('number');
            $table->unsignedInteger('total');
            $table->string('language');
            $table->string('new_chars');
            $table->text('text')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'language', 'number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
