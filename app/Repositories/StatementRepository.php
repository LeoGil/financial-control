<?php

namespace App\Repositories;

use App\Models\Installment;
use App\Models\Statement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StatementRepository
{
    protected $userId;

    public function __construct()
    {
        $this->userId = Auth::user()->id;
    }
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

        $now = now();
        $status = 'upcoming';

        if ($now->between($openingDate, $closingDate)) {
            $status = 'open';
        } elseif ($now->greaterThan($closingDate) && $now->lessThanOrEqualTo($dueDate)) {
            $status = 'closed';
        } elseif ($now->greaterThan($dueDate)) {
            $status = 'overdue';
        }

        return Statement::create([
            'account_id' => $accountId,
            'opening_date' => $openingDate,
            'closing_date' => $closingDate,
            'due_date' => $dueDate,
            'total_amount' => 0,
            'status' => $status,
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
            ->with(['transaction.creditCard', 'transaction.category']) // carrega os relacionamentos corretamente
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

    public function getTotalByStatus(string $status)
    {
        return Statement::whereHas('account', function ($query) {
            $query->where('user_id', $this->userId);
        })
            ->where('status', $status)
            ->sum('total_amount');
    }

    public function getTotalPaidThisMonth()
    {
        return Statement::whereHas('account', function ($query) {
            $query->where('user_id', $this->userId);
        })
            ->where('status', 'paid')
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('total_amount');
    }

    public function getNextDueDate()
    {
        $date = Statement::whereHas('account', function ($query) {
            $query->where('user_id', $this->userId);
        })
            ->where('status', 'open')
            ->orderBy('due_date', 'asc')
            ->value('due_date');

        return $date ? Carbon::parse($date)->format('d/m/Y') : null;
    }
}
