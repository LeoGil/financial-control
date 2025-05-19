<?php

namespace App\Services;

use App\Models\Statement;
use App\Repositories\StatementRepository;
use Carbon\Carbon;

class StatementService
{
    private StatementRepository $statementRepository;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->statementRepository = new StatementRepository();
    }

    /**
     * Busca e marca como overdue todas as statements vencidas
     * de todas as contas do usuário.
     */
    public function checkOverdueForUser(int $userId): void
    {
        $today = Carbon::today();

        // Busca faturas vencidas via repositório
        $overdueStatements = $this->statementRepository->getOverdueByUser($userId, $today);

        // Marca cada uma como overdue
        foreach ($overdueStatements as $statement) {
            $this->markAsOverdue($statement);
        }
    }

    /**
     * Marca uma statement como overdue.
     */
    private function markAsOverdue(Statement $statement): void
    {
        $statement->status = 'overdue';
        $statement->save();
    }

    public function checkNextCurrentStatements(int $userId): void
    {
        $nextStatements = $this->statementRepository->checkNextCurrentStatements($userId);

        foreach ($nextStatements as $statement) {
            $this->markAsOpen($statement);
        }
    }

    private function markAsOpen(Statement $statement): void
    {
        $statement->status = 'open';
        $statement->save();
    }
}
