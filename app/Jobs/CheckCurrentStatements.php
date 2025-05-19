<?php

namespace App\Jobs;

use App\Services\StatementService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CheckCurrentStatements implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    protected int $userId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(StatementService $statementService): void
    {
        $statementService->checkNextCurrentStatements($this->userId);
    }
}
