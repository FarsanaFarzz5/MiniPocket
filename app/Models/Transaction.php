<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Mass assignable fields
protected $fillable = [
    'parent_id', 'kid_id', 'amount', 'status', 'type', 'description', 'payment_method', 'source'
];


    /**
     * Relationship: Transaction belongs to a parent (User)
     */
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    /**
     * Relationship: Transaction belongs to a kid (User)
     */
    public function kid()
    {
        return $this->belongsTo(User::class, 'kid_id');
    }

    /**
     * Scope to get only debit transactions
     */
    public function scopeDebit($query)
    {
        return $query->where('type', 'debit');
    }

    /**
     * Scope to get only credit transactions
     */
    public function scopeCredit($query)
    {
        return $query->where('type', 'credit');
    }

    /**
     * Helper to get formatted amount
     */
    public function formattedAmount()
    {
        return number_format($this->amount, 2);
    }

    /**
     * Helper to get transaction description
     */
    public function transactionDescription()
    {
        return $this->description ?? ($this->type === 'debit' 
            ? 'Sent to ' . $this->kid->first_name 
            : 'Received from ' . $this->parent->first_name);
    }
}
