<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

protected $fillable = [
    'first_name',
    'second_name',
    'email',
    'phone_no',
    'password',
    'role',
    'parent_id',
    'invite_token',
    'dob',
    'gender',
    'profile_img',
    'daily_limit',
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // relation for children
    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    // relation for parent
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function sendPasswordResetNotification($token)
{
    $url = url('/reset-password?token=' . $token . '&email=' . urlencode($this->email));

    Mail::to($this->email)->send(new PasswordResetMail($this->first_name, $url));
}
    
}   
