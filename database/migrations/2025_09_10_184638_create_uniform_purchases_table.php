<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('uniform_purchases', function (Blueprint $table) {
            $table->id();
            $table->date('purchase_date');
            $table->string('purchase_number')->unique();
            $table->string('supplier_name');
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('uniform_purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained('uniform_purchases')->onDelete('cascade');
            $table->foreignId('uniform_master_id')->constrained('uniform_masters')->onDelete('cascade');
            $table->integer('quantity')->default(0);
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('total', 12, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('uniform_purchase_items');
        Schema::dropIfExists('uniform_purchases');
    }
};
