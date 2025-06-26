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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->string('payee'); // Who was paid or who paid
            $table->text('memo')->nullable(); // Description/note
            $table->decimal('amount', 15, 2); // Positive for income, negative for expenses
            $table->string('type'); // income, expense, transfer
            $table->date('transaction_date');
            $table->boolean('cleared')->default(false); // Bank reconciliation
            $table->boolean('approved')->default(true); // User approved
            $table->timestamps();
            
            // Index for performance
            $table->index(['user_id', 'transaction_date']);
            $table->index(['account_id', 'transaction_date']);
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
