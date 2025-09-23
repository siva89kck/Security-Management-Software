<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Employees
        Schema::table('employees', function (Blueprint $table) {
            $table->index('status', 'idx_employees_status');
            $table->index('phone', 'idx_employees_phone');
            $table->index('mobile', 'idx_employees_mobile');
        });

        // Employee Addresses
        Schema::table('employee_addresses', function (Blueprint $table) {
            $table->index(['city', 'state'], 'idx_emp_addresses_city_state');
            $table->index('pincode', 'idx_emp_addresses_pincode');
        });

        // Employee Bank Details
        Schema::table('employee_bank_details', function (Blueprint $table) {
            $table->unique('account_no', 'uniq_emp_bank_account_no');
            $table->index('ifsc_code', 'idx_emp_bank_ifsc');
        });

        // Employee Enclosures
        Schema::table('employee_enclosures', function (Blueprint $table) {
            $table->index('document_type', 'idx_emp_enclosures_doc_type');
            $table->index('proof_no', 'idx_emp_enclosures_proof_no');
        });

        // Employee Experiences
        Schema::table('employee_experiences', function (Blueprint $table) {
            $table->index('company_name', 'idx_emp_experiences_company');
        });

        // Employee Family Members
        Schema::table('employee_family_members', function (Blueprint $table) {
            $table->index('relationship', 'idx_emp_family_relationship');
        });

        // Employee Languages
        Schema::table('employee_languages', function (Blueprint $table) {
            $table->index('language', 'idx_emp_languages_lang');
        });

        // Employee Official Details
        Schema::table('employee_official_details', function (Blueprint $table) {
            $table->index('role', 'idx_emp_official_role');
            $table->index('employee_type', 'idx_emp_official_type');
        });

        // Employee Payslip Configs
        Schema::table('employee_payslip_configs', function (Blueprint $table) {
            $table->index(['basic', 'hra'], 'idx_emp_payslip_basic_hra');
        });

        // Uniform Masters
        Schema::table('uniform_masters', function (Blueprint $table) {
            $table->index('status', 'idx_uniform_masters_status');
            $table->index('name', 'idx_uniform_masters_name');
        });

        // Uniform Purchases
        Schema::table('uniform_purchases', function (Blueprint $table) {
            $table->index('purchase_date', 'idx_uniform_purchases_date');
            $table->index('supplier_name', 'idx_uniform_purchases_supplier');
        });

        // Uniform Purchase Items
        Schema::table('uniform_purchase_items', function (Blueprint $table) {
            $table->index('quantity', 'idx_uniform_purchase_items_qty');
        });

        // Uniform Issues
        Schema::table('uniform_issues', function (Blueprint $table) {
            $table->index('issue_date', 'idx_uniform_issues_date');
        });

        // Uniform Issue Items
        Schema::table('uniform_issue_items', function (Blueprint $table) {
            $table->index('quantity', 'idx_uniform_issue_items_qty');
        });

        // Uniform Stocks
        Schema::table('uniform_stocks', function (Blueprint $table) {
            $table->index('remaining_stock', 'idx_uniform_stocks_remaining');
        });

        // Users
        Schema::table('users', function (Blueprint $table) {
            $table->index('role', 'idx_users_role');
            $table->index('phone', 'idx_users_phone');
        });
    }

    public function down(): void
    {
        // Rollback by dropping indexes
        Schema::table('employees', function (Blueprint $table) {
            $table->dropIndex('idx_employees_status');
            $table->dropIndex('idx_employees_phone');
            $table->dropIndex('idx_employees_mobile');
        });

        Schema::table('employee_addresses', function (Blueprint $table) {
            $table->dropIndex('idx_emp_addresses_city_state');
            $table->dropIndex('idx_emp_addresses_pincode');
        });

        Schema::table('employee_bank_details', function (Blueprint $table) {
            $table->dropUnique('uniq_emp_bank_account_no');
            $table->dropIndex('idx_emp_bank_ifsc');
        });

        Schema::table('employee_enclosures', function (Blueprint $table) {
            $table->dropIndex('idx_emp_enclosures_doc_type');
            $table->dropIndex('idx_emp_enclosures_proof_no');
        });

        Schema::table('employee_experiences', function (Blueprint $table) {
            $table->dropIndex('idx_emp_experiences_company');
        });

        Schema::table('employee_family_members', function (Blueprint $table) {
            $table->dropIndex('idx_emp_family_relationship');
        });

        Schema::table('employee_languages', function (Blueprint $table) {
            $table->dropIndex('idx_emp_languages_lang');
        });

        Schema::table('employee_official_details', function (Blueprint $table) {
            $table->dropIndex('idx_emp_official_role');
            $table->dropIndex('idx_emp_official_type');
        });

        Schema::table('employee_payslip_configs', function (Blueprint $table) {
            $table->dropIndex('idx_emp_payslip_basic_hra');
        });

        Schema::table('uniform_masters', function (Blueprint $table) {
            $table->dropIndex('idx_uniform_masters_status');
            $table->dropIndex('idx_uniform_masters_name');
        });

        Schema::table('uniform_purchases', function (Blueprint $table) {
            $table->dropIndex('idx_uniform_purchases_date');
            $table->dropIndex('idx_uniform_purchases_supplier');
        });

        Schema::table('uniform_purchase_items', function (Blueprint $table) {
            $table->dropIndex('idx_uniform_purchase_items_qty');
        });

        Schema::table('uniform_issues', function (Blueprint $table) {
            $table->dropIndex('idx_uniform_issues_date');
        });

        Schema::table('uniform_issue_items', function (Blueprint $table) {
            $table->dropIndex('idx_uniform_issue_items_qty');
        });

        Schema::table('uniform_stocks', function (Blueprint $table) {
            $table->dropIndex('idx_uniform_stocks_remaining');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_role');
            $table->dropIndex('idx_users_phone');
        });
    }
};