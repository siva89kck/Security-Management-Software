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
        Schema::create('employees', function (Blueprint $table) {
    $table->id();
    $table->string('first_name')->nullable();
    $table->string('last_name')->nullable();
    $table->string('father_name')->nullable();
    $table->date('dob')->nullable();
    $table->enum('gender', ['male','female','other'])->nullable();
    $table->integer('age')->nullable();
    $table->string('photo')->nullable();

    // Personal details
    $table->string('phone')->nullable();
    $table->string('mobile')->nullable();
    $table->string('alt_mobile')->nullable();
    $table->string('education_qualification')->nullable();
    $table->string('marital_status')->nullable();
    $table->string('nationality')->nullable();
    $table->string('religion')->nullable();
    $table->string('caste')->nullable();
    $table->string('sub_caste')->nullable();
    $table->string('identification_marks')->nullable();
    $table->text('remarks')->nullable();
    $table->string('recommended_by')->nullable();
    $table->string('recommended_address')->nullable();
    $table->string('blood_group')->nullable();

    // track creator
    $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

    $table->timestamps();
    $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
