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
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('description');
            $table->integer('publication_type_id')->nullable();
            $table->string('organization_name')->nullable();
            $table->string('ISSN')->nullable();
            $table->string('cover_image');
            $table->integer('published_year');
            $table->integer('status_id');
            $table->string('full_text');
            $table->unsignedBigInteger('main_person_id')->nullable();
            $table->foreign('main_person_id')->references('id')->on('persons');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
