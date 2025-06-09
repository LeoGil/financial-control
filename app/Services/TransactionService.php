<?php

namespace App\Services;

use App\Models\Transaction;
use App\Repositories\AccountRepository;
use App\Repositories\StatementRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\InstallmentRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected TransactionRepository $transactionRepository,
        protected AccountRepository $accountRepository,
        protected StatementRepository $statementRepository,
        protected InstallmentRepository $installmentRepository
    ) {}

    public function store($data)
    {
        $account = $this->accountRepository->getByCreditCardId($data['credit_card_id']);
        $purchaseDate = $this->parseDate($data['date']);

        $transaction = $this->transactionRepository->store([
            'credit_card_id'     => $data['credit_card_id'],
            'date'               => $purchaseDate->format('Y-m-d'),
            'name'               => $data['name'],
            'description'        => $data['description'] ?? null,
            'amount'             => $data['amount'],
            'category_id'        => $data['category_id'],
            'subcategory_id'     => $data['subcategory_id'] ?? null,
            'budget_category_id' => $data['budget_category_id'] ?? null,
        ]);

        $installmentCount = $data['installment'];
        $installmentValue = $data['amount'] / $installmentCount;

        $firstStatementDate = $this->getFirstStatementDate($purchaseDate, $account->closing_day);
        $installmentDates = $this->generateInstallmentsDates($firstStatementDate, $installmentCount);

        foreach ($installmentDates as $i => $statementMonthDate) {
            $statement = $this->statementRepository->findOrCreateStatement(
                $account->id,
                $statementMonthDate,
                $account->closing_day,
                $account->due_day
            );

            $this->installmentRepository->store([
                'transaction_id'      => $transaction->id,
                'statement_id'        => $statement->id,
                'installment_number'  => $i + 1,
                'installment_total'   => $installmentCount,
                'amount'              => $installmentValue,
            ]);

            $this->statementRepository->incrementTotalAmount($statement, $installmentValue);
        }

        return $transaction;
    }

    public function destroy(Transaction $transaction): void
    {
        // 1) carrega todas as installments com statements
        $installments = $transaction
            ->installments()
            ->with('statement')
            ->get();

        // 2) agrupa por statement_id
        $grouped = $installments
            ->groupBy('statement_id')
            ->map(fn($g) => [
                'count' => $g->count(),
                'sum_amount' => $g->sum('amount'),
            ])
            ->toArray();

        // 3) executa ajustes e delete em transação
        DB::transaction(function () use ($grouped, $transaction) {
            $this->statementRepository->adjustAfterTransactionDeletion($grouped);
            $this->transactionRepository->delete($transaction);
        });
    }

    public function update(Transaction $transaction, array $data): void
    {
        $this->destroy($transaction);
        $this->store($data);
    }

    private function parseDate($date)
    {
        return Carbon::parse($date);
    }

    private function getFirstStatementDate(Carbon $purchaseDate, int $closingDay): Carbon
    {
        if ($purchaseDate->day <= $closingDay) {
            return $purchaseDate->copy()->startOfMonth();
        }

        return $purchaseDate->copy()->addMonthNoOverflow()->startOfMonth();
    }

    private function generateInstallmentsDates(Carbon $firstStatementDate, int $installments): array
    {
        $dates = [];

        for ($i = 0; $i < $installments; $i++) {
            $dates[] = $firstStatementDate->copy()->addMonthsNoOverflow($i);
        }

        return $dates;
    }
}
