<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('uniform_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uniform_master_id')->constrained('uniform_masters')->onDelete('cascade');
            $table->integer('total_purchased')->default(0);
            $table->integer('total_issued')->default(0);
            $table->integer('remaining_stock')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('uniform_stocks');
    }
};
