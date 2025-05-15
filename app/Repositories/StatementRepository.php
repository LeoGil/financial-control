<?php

namespace App\Repositories;

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
            'status' => $dueDate->isPast() ? 'overdue' : 'open',
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
}
