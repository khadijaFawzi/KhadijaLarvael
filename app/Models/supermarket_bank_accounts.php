<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supermarket_bank_accounts extends Model
{
    use HasFactory;
    protected $fillable = [
        'supermarket_id',
        'bank_name',
        'account_number',
        'iban',
        'account_holder_name',
        'bank_logo',
    ];

    public function supermarket()
    {
        return $this->belongsTo(Supermarket::class);
    }
}
