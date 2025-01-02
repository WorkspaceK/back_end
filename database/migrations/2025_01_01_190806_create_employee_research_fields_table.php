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
        Schema::create('employee_research_fields', function (Blueprint $table) {
            $table->id();
            $table->integer('rate')->nullable();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('research_field_id');

            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('research_field_id')->references('id')->on('research_fields');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_research_fields');
    }
};
