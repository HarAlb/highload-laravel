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
        Schema::create('medias', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('mediable_type');
            $table->unsignedBigInteger('mediable_id');
            $table->foreignId('parent_id')->nullable()->references('id')->on('medias');
            $table->boolean('is_complied')->default(false);
            $table->string('disk', 6);
            $table->string('path');
            $table->string('filename', 64);
            $table->string('extension');
            $table->string('size')->nullable();
            $table->unsignedTinyInteger('position');
            $table->timestamps();

            $table->index(['mediable_type', 'mediable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medias');
    }
};
