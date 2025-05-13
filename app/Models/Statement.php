<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statement extends Model
{
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
