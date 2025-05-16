<?php

namespace App\Repositories;

use App\Models\Installment;
use App\Models\Statement;

class InstallmentRepository
{
    public function store($data)
    {
        return Installment::create($data);
    }

    public function destroyByStatement(Statement $statement)
    {
        $statement->installments()->delete();
    }
}
