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
        Schema::table('employee_family_members', function (Blueprint $table) {
            $table->string('mobile_number', 15)->nullable()->after('marital_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_family_members', function (Blueprint $table) {
            $table->dropColumn('mobile_number');
        });
    }
};
