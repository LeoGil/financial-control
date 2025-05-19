<?php

namespace App\Repositories;

use App\Models\Installment;
use App\Models\Statement;
use Carbon\Carbon;

class StatementRepository
{
    public function findOrCreateStatement($accountId, Carbon $baseDate, $closingDay, $dueDay)
    {
        $year = $baseDate->year;
        $month = $baseDate->month;

        $existing = Statement::where('account_id', $accountId)
            ->whereYear('closing_date', $year)
            ->whereMonth('closing_date', $month)
            ->first();

        if ($existing) {
            return $existing;
        }

        $closingDate = Carbon::create($year, $month, $closingDay)->endOfDay();
        $openingDate = $closingDate->copy()->subMonth()->addDay();
        $dueDate = Carbon::create($year, $month, $dueDay)->endOfDay();

        return Statement::create([
            'account_id' => $accountId,
            'opening_date' => $openingDate,
            'closing_date' => $closingDate,
            'due_date' => $dueDate,
            'total_amount' => 0,
            'status' => $dueDate->isPast() ? 'paid' : 'open',
        ]);
    }

    public function incrementTotalAmount(Statement $statement, $amount)
    {
        $statement->increment('total_amount', $amount);
    }

    public function pay(Statement $statement)
    {
        $statement->update([
            'status' => 'paid',
            'payment_date' => now(),
        ]);
    }

    public function getInstallments(Statement $statement)
    {
        return Installment::query()
        ->join('transactions', 'installments.transaction_id', '=', 'transactions.id')
        ->where('installments.statement_id', $statement->id)
        ->with(['transaction.creditCard']) // carrega os relacionamentos corretamente
        ->orderBy('transactions.date')
        ->select('installments.*') // importante: mantém o retorno como Installment
        ->get();
    }

    /**
     * Ajusta os statements após exclusão de uma transaction.
     *
     * @param array<int, array{count:int, sum_amount:float}> $groupedData
     */
    public function adjustAfterTransactionDeletion(array $groupedData): void
    {
        $statementIds = array_keys($groupedData);

        $statements = Statement::withCount('installments')
            ->whereIn('id', $statementIds)
            ->get();

        foreach ($statements as $statement) {
            $txData = $groupedData[$statement->id];
            $remaining = $statement->installments_count - $txData['count'];

            if ($remaining < 1) {
                $statement->delete();
            } else {
                $statement->decrement('total_amount', $txData['sum_amount']);
            }
        }
    }
}
