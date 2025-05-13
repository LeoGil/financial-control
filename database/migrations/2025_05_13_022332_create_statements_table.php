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
        Schema::create('statements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('credit_card_id')->constrained()->onDelete('cascade');
            $table->date('opening_date');
            $table->date('closing_date');
            $table->date('due_date');
            $table->date('payment_date')->nullable();
            $table->decimal('total_amount', 12, 2);
            $table->enum('status', ['open', 'closed', 'paid', 'overdue'])->default('open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statements');
    }
};
