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
        Schema::create('publication_authors', function (Blueprint $table) {
            $table->id();
            $table->float('norm')->nullable();

            $table->unsignedBigInteger('publication_id');
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('author_role_id');

            $table->foreign('publication_id')->references('id')->on('publications');
            $table->foreign('person_id')->references('id')->on('persons');
            $table->foreign('author_role_id')->references('id')->on('author_roles');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publication_authors');
    }
};
