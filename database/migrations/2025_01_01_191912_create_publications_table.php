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
            $table->string('name', 500)->unique();
            $table->string('description')->nullable();
            $table->string('organization_name', 500)->unique();
            $table->string('ISSN', 100)->unique();
            $table->string('cover_image', 500)->nullable();
            $table->integer('published_year')->nullable();
            $table->string('full_text')->nullable();

            $table->unsignedBigInteger('publication_type_id')->unique();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->unsignedBigInteger('person_id')->nullable();

            $table->foreign('publication_type_id')->references('id')->on('publication_types');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('person_id')->references('id')->on('persons');

            $table->timestamps();
            $table->softDeletes();
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
