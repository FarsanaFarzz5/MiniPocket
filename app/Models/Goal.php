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
    ];

    protected $attributes = [
    'status' => 0, // default incomplete
];
    public function savings()
    {
        return $this->hasMany(GoalSaving::class);
    }

    public function kid()
    {
        return $this->belongsTo(User::class, 'kid_id');
    }
}
