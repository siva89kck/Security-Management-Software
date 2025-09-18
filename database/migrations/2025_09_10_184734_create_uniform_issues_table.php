<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('uniform_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->date('issue_date');
            $table->string('issue_number')->unique();
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('uniform_issue_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('issue_id')->constrained('uniform_issues')->onDelete('cascade');
            $table->foreignId('uniform_master_id')->constrained('uniform_masters')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('total', 12, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('uniform_issue_items');
        Schema::dropIfExists('uniform_issues');
    }
};
