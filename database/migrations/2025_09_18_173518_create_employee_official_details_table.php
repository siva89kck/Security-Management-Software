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
        Schema::create('employee_official_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->enum('role', ['Security Guard(SG)', 'Head Guard(HG)',
             'Security Officer(SO)', 'Assistant Security Officer(ASO)',
             'House Keeping(HK)', 'Operation Manager(OM)', 'Field Officer(FO)',
             'Gardener', 'MST', 'Electrician', 'Office Assistant', 'Admin Manager',
             'Admin Assistant'])
      ->nullable()
      ->default('Security Guard(SG)');
            $table->date('date_of_join')->nullable();
            $table->enum('employee_type', ['Permanent','Temporary']);
            $table->decimal('salary',10,2)->default(0);
            $table->string('pf_number')->nullable();
            $table->string('esi_number')->nullable();
            $table->boolean('pf_calculation')->default(false);
            $table->boolean('esi_calculation')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_official_details');
    }
};
