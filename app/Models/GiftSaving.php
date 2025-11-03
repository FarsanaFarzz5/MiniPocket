<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftSaving extends Model
{
    use HasFactory;

    protected $fillable = [
        'gift_id',
        'kid_id',
        'parent_id',
        'saved_amount',
        'type',
        'status',
    ];

    public function gift()
    {
        return $this->belongsTo(Gift::class);
    }

    public function kid()
    {
        return $this->belongsTo(User::class, 'kid_id');
    }
}
