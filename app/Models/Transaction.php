<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['parent_id', 'kid_id', 'amount', 'status', 'type', 'description'];

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function kid()
    {
        return $this->belongsTo(User::class, 'kid_id');
    }
}

