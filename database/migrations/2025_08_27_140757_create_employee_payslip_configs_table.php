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
        Schema::create('employee_payslip_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->decimal('basic',5,2)->nullable();
            $table->decimal('allowance1',5,2)->nullable();
            $table->decimal('hra',5,2)->nullable();
            $table->decimal('allowance2',5,2)->nullable();
            $table->decimal('da',5,2)->nullable();
            $table->decimal('gratuity',5,2)->nullable();
            $table->decimal('travel_allowance',5,2)->nullable();
            $table->decimal('bonus',5,2)->nullable();
            $table->decimal('leave_allowance',5,2)->nullable();
            $table->decimal('other_allowance',5,2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_payslip_configs');
    }
};
