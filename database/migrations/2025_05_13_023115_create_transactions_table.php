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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('statement_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('credit_card_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->string('name');
            $table->string('description')->nullable();
            $table->decimal('amount', 12, 2);
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('subcategory_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('installment');
            $table->tinyInteger('installment_number');
            $table->string('merchant');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
