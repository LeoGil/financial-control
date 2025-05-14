<?php

namespace App\Repositories;

use App\Models\Installment;

class InstallmentRepository
{
    public function store($data)
    {
        return Installment::create($data);
    }
}
