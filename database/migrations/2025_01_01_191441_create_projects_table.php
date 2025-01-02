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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name', 500);
            $table->text('description')->nullable();
            $table->integer('member_no')->default(1);
            $table->integer('rank')->default(1)->between(1, 10);

            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('research_field_id');
            $table->unsignedBigInteger('project_type_id')->nullable();

            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('research_field_id')->references('id')->on('research_fields');
            $table->foreign('project_type_id')->references('id')->on('project_types');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
