<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('company_name');
            $table->string('location');
            $table->string('salary_min')->nullable();
            $table->string('salary_max')->nullable();
            $table->enum('job_type', ['full-time', 'part-time', 'contract', 'remote', 'internship']);
            $table->enum('status', ['active', 'filled', 'expired', 'draft'])->default('active');
            $table->date('closing_date')->nullable();
            $table->string('external_url')->nullable(); // For API jobs
            $table->string('external_id')->nullable(); // For API jobs
            $table->string('source')->default('internal'); // internal, adzuna, remotive
            $table->json('requirements')->nullable();
            $table->json('benefits')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};
