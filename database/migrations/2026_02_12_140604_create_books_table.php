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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('author');
            $table->string('publisher');
            $table->string('place_of_publication');
            $table->string('year_of_publication');
            $table->string('isbn_issn')->nullable();
            $table->string('language')->nullable();
            $table->string('collation')->nullable();
            $table->string('gmd_type')->nullable(); // General Material Designation
            $table->string('classification')->nullable();
            $table->string('call_number')->nullable();
            $table->string('subject')->nullable();
            $table->text('abstract')->nullable();
            $table->string('cover_image')->nullable();
            $table->integer('total_items')->default(0);
            $table->string('edition')->nullable();
            $table->string('frequency_of_publication')->nullable();
            $table->string('series_title')->nullable();
            $table->string('attachment')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
