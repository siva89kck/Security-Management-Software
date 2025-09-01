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
        Schema::table('employee_payslip_configs', function (Blueprint $table) {
           $table->decimal('basic', 5, 2)->default(0.00)->change();
            $table->decimal('allowance1', 5, 2)->default(0.00)->change();
            $table->decimal('hra', 5, 2)->default(0.00)->change();
            $table->decimal('allowance2', 5, 2)->default(0.00)->change();
            $table->decimal('da', 5, 2)->default(0.00)->change();
            $table->decimal('gratuity', 5, 2)->default(0.00)->change();
            $table->decimal('travel_allowance', 5, 2)->default(0.00)->change();
            $table->decimal('bonus', 5, 2)->default(0.00)->change();
            $table->decimal('leave_allowance', 5, 2)->default(0.00)->change();
            $table->decimal('other_allowance', 5, 2)->default(0.00)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_payslip_configs', function (Blueprint $table) {
            $table->decimal('basic', 5, 2)->nullable()->change();
            $table->decimal('allowance1', 5, 2)->nullable()->change();
            $table->decimal('hra', 5, 2)->nullable()->change();
            $table->decimal('allowance2', 5, 2)->nullable()->change();
            $table->decimal('da', 5, 2)->nullable()->change();
            $table->decimal('gratuity', 5, 2)->nullable()->change();
            $table->decimal('travel_allowance', 5, 2)->nullable()->change();
            $table->decimal('bonus', 5, 2)->nullable()->change();
            $table->decimal('leave_allowance', 5, 2)->nullable()->change();
            $table->decimal('other_allowance', 5, 2)->nullable()->change();
        });
    }
};
