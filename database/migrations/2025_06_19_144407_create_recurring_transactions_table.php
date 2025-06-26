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
        Schema::create('recurring_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->string('description');
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['income', 'expense', 'transfer']);
            $table->enum('frequency', ['daily', 'weekly', 'monthly', 'yearly']);
            $table->integer('interval')->default(1); // Every X days/weeks/months/years
            $table->date('start_date');
            $table->date('end_date')->nullable(); // Optional end date
            $table->date('next_due_date');
            $table->integer('max_occurrences')->nullable(); // Optional max number of times
            $table->integer('occurrences_created')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('metadata')->nullable(); // For storing additional data like day of week, day of month, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurring_transactions');
    }
};
