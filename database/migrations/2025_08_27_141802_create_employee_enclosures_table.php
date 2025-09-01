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
        Schema::create('employee_enclosures', function (Blueprint $table) {
        $table->id();
        $table->foreignId('employee_id')->constrained()->onDelete('cascade');
        $table->enum('document_type', [
            'PAN CARD',
            'AADHAR CARD',
            'VOTER ID',
            'RATION CARD',
            'Driving License',
            'SCHOOL CERTIFICATE',
            'DEGREE CERTIFICATE'
        ])->nullable();
        $table->enum('original_copy', ['Original','Xerox'])->nullable();
        $table->string('proof_no')->nullable();
        $table->string('file_path')->nullable();
        $table->timestamps();
        $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_enclosures');
    }
};
