<?php

namespace App\Console\Commands;

use App\Models\RecurringTransaction;
use Illuminate\Console\Command;

class ProcessRecurringTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recurring:process {--dry-run : Show what would be processed without actually processing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process due recurring transactions and create actual transactions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        $this->info('Processing recurring transactions...');
        
        // Get all due recurring transactions
        $dueTransactions = RecurringTransaction::with(['account', 'category', 'user'])
            ->where('is_active', true)
            ->where('next_due_date', '<=', now()->toDateString())
            ->get();

        if ($dueTransactions->isEmpty()) {
            $this->info('No recurring transactions are due for processing.');
            return;
        }

        $this->info("Found {$dueTransactions->count()} recurring transactions due for processing:");
        
        $processed = 0;
        $errors = 0;

        foreach ($dueTransactions as $recurring) {
            if (!$recurring->shouldCreateTransaction()) {
                continue;
            }

            $this->line(sprintf(
                "- %s: %s (¥%s) for %s",
                $recurring->user->name,
                $recurring->description,
                number_format(abs($recurring->amount)),
                $recurring->account->name
            ));

            if (!$dryRun) {
                try {
                    $transaction = $recurring->createTransaction();
                    $this->info("  ✓ Created transaction ID: {$transaction->id}");
                    $processed++;
                } catch (\Exception $e) {
                    $this->error("  ✗ Failed to create transaction: " . $e->getMessage());
                    $errors++;
                }
            } else {
                $this->info("  → Would create transaction (dry run)");
                $processed++;
            }
        }

        if ($dryRun) {
            $this->info("\nDry run completed. {$processed} transactions would be processed.");
        } else {
            $this->info("\nProcessing completed!");
            $this->info("✓ Successfully processed: {$processed}");
            if ($errors > 0) {
                $this->error("✗ Errors: {$errors}");
            }
        }
    }
}
