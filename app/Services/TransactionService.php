<?php

namespace App\Services;

use App\Repositories\CreditCardRepository;
use App\Repositories\StatementRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\InstallmentRepository;
use Carbon\Carbon;

class TransactionService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected TransactionRepository $transactionRepository,
        protected CreditCardRepository $creditCardRepository,
        protected StatementRepository $statementRepository,
        protected InstallmentRepository $installmentRepository
    ) {}

    public function store($data)
    {
        $creditCard = $this->creditCardRepository->getById($data['credit_card_id']);
        $purchaseDate = $this->parseDate($data['date']);

        $transaction = $this->transactionRepository->store([
            'credit_card_id'     => $data['credit_card_id'],
            'date'               => $purchaseDate->format('Y-m-d'),
            'name'               => $data['name'],
            'description'        => $data['description'] ?? null,
            'amount'             => $data['value'],
            'category_id'        => $data['category_id'],
            'subcategory_id'     => $data['subcategory_id'] ?? null,
            'budget_category_id' => $data['budget_category_id'] ?? null,
        ]);

        $installmentCount = $data['installment'];
        $installmentValue = $data['value'] / $installmentCount;

        $firstStatementDate = $this->getFirstStatementDate($purchaseDate, $creditCard->closing_day);
        $installmentDates = $this->generateInstallmentsDates($firstStatementDate, $installmentCount);

        foreach ($installmentDates as $i => $statementMonthDate) {
            $statement = $this->statementRepository->findOrCreateStatement(
                $creditCard->account_id,
                $statementMonthDate,
                $creditCard->closing_day,
                $creditCard->due_day
            );

            $this->installmentRepository->store([
                'transaction_id'      => $transaction->id,
                'statement_id'        => $statement->id,
                'installment_number'  => $i + 1,
                'installment_total'   => $installmentCount,
                'amount'              => $installmentValue,
            ]);
        }

        return $transaction;
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

        return $purchaseDate->copy()->addMonth()->startOfMonth();
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
