<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bank_name',
        'card_number',
        'expiry_date',
        'cvv',
        'branch_name',
        'is_selected',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

