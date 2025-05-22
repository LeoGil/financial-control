<?php

namespace App\Repositories;

use App\Models\Account;
use App\Models\Installment;
use App\Models\Statement;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
            ->with(['transaction.creditCard', 'transaction.category'])
            ->orderByDesc('transactions.date')
            ->select('installments.*')
            ->get();
    }

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

    public function getTotalByStatus(string $status, int $userId)
    {
        return Statement::whereHas('account', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->where('status', $status)
            ->sum('total_amount');
    }

    public function getTotalPaidThisMonth(int $userId)
    {
        return Statement::whereHas('account', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->where('status', 'paid')
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('total_amount');
    }

    public function getNextDueDate(int $userId)
    {
        $date = Statement::whereHas('account', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->where('status', 'open')
            ->orderBy('due_date', 'asc')
            ->value('due_date');

        return $date ? Carbon::parse($date)->format('d/m/Y') : null;
    }

    public function getOverdueByUser(int $userId)
    {
        $today = Carbon::now();

        return Statement::query()
            ->whereHas('account', fn($q) => $q->where('user_id', $userId))
            ->where('due_date', '<', $today)
            ->whereNotIn('status', ['paid', 'overdue'])
            ->get();
    }

    public function checkNextCurrentStatements(int $userId)
    {
        return Statement::whereHas('account', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->where('status', 'upcoming')
            ->where('opening_date', '<=', now())
            ->get();
    }

    public function getByAccount(Account $account, int $perPage = 12)
    {
        return $account->statements()->orderByDesc('opening_date')->paginate($perPage);
    }

    public function reportMonthByMonth(int $userId)
    {
        return DB::table('statements')
            ->join('accounts', 'statements.account_id', '=', 'accounts.id')
            ->where('accounts.user_id', $userId)
            ->selectRaw("DATE_FORMAT(statements.due_date, '%Y-%m') as month, accounts.name as account, SUM(statements.total_amount) as total")
            ->groupBy('month', 'account')
            ->orderBy('month')
            ->get()
            ->toArray();
    }
}
