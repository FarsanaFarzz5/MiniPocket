<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

protected $fillable = [
    'kid_id',
    'title',
    'target_amount',
    'saved_amount',
    'status',
    'image',
    'is_hidden', 
    'is_locked',  // NEW
];


 protected $attributes = [
    'status' => 0,    // On Progress
    'is_hidden' => 0, // Visible by default
];

    // 🟡 Auto mark as Completed when fully saved
    public static function boot()
    {
        parent::boot();

        static::saving(function ($goal) {
            if ($goal->saved_amount >= $goal->target_amount && $goal->status == 0) {
                $goal->status = 1; // ✅ Completed
            }
        });
    }

    // ✅ Label for UI
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            0 => 'On Progress',
            1 => 'Completed',
            2 => 'Paid',
            default => 'Unknown',
        };
    }

    // ✅ Star CSS class helper
    public function getStatusClassAttribute()
    {
        return match ($this->status) {
            0 => 'processing', // 🟡 On Progress
            1 => 'fulfilled',  // 🟡 Completed
            2 => 'complete',   // ⚪ Paid
            default => 'processing',
        };
    }

    // ✅ Simple boolean helpers
    public function isCompleted() { return $this->status == 1; }
    public function isPaid() { return $this->status == 2; }

    public function savings()
    {
        return $this->hasMany(GoalSaving::class);
    }

    public function kid()
    {
        return $this->belongsTo(User::class, 'kid_id');
    }
}
