<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    use HasFactory;

    protected $fillable = [
        'kid_id',
        'title',
        'target_amount',
        'saved_amount',
        'image',
    ];

    public function kid()
    {
        return $this->belongsTo(User::class, 'kid_id');
    }
}
