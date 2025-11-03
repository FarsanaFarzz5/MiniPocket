<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoalSaving extends Model
{
    use HasFactory;

    protected $fillable = [
        'goal_id',
        'kid_id',
        'parent_id',
        'saved_amount',
        'type',
        'status',
    ];

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

    public function kid()
    {
        return $this->belongsTo(User::class, 'kid_id');
    }
}
