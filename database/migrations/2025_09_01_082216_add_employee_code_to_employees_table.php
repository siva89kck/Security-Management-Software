<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Add columns if they don't exist
        Schema::table('employees', function (Blueprint $table) {
            if (!Schema::hasColumn('employees', 'employee_code')) {
                $table->string('employee_code')->nullable()->after('id');
            }
            if (!Schema::hasColumn('employees', 'status')) {
                $table->enum('status', ['active','inactive'])->default('active')->after('employee_code');
            }
        });

        // 2) Standardize any existing rows to a deterministic, unique code: EMP-1001 + id-1
        //    Example: id=1 => EMP-1001, id=2 => EMP-1002
        DB::statement("
            UPDATE employees
            SET employee_code = CONCAT('EMP-', LPAD(id + 1000, 4, '0'))
            WHERE employee_code IS NULL
               OR employee_code = ''
               OR employee_code LIKE 'EMP--%%'
               OR employee_code REGEXP '^EMP-0*[0-9]+$'
               OR employee_code NOT REGEXP '^EMP-[0-9]+$'
        ");

        // 3) Add unique index (safe now that all existing codes are unique)
        Schema::table('employees', function (Blueprint $table) {
            // If you already have a unique index with a different name, drop it first manually.
            $table->unique('employee_code', 'employees_employee_code_unique');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // drop unique first
            $table->dropUnique('employees_employee_code_unique');
            // optional: drop columns (comment these out if you want to keep them on rollback)
            $table->dropColumn('employee_code');
            $table->dropColumn('status');
        });
    }
};
