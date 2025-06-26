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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->integer('month'); // 1-12
            $table->integer('year'); // YYYY
            $table->decimal('allocated_amount', 15, 2)->default(0); // Amount budgeted
            $table->decimal('spent_amount', 15, 2)->default(0); // Amount spent
            $table->decimal('available_amount', 15, 2)->default(0); // Remaining available
            $table->timestamps();
            
            // Unique constraint to prevent duplicate budget entries
            $table->unique(['user_id', 'category_id', 'month', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
