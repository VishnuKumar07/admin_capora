<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminUser extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'admin_users';   

    protected $fillable = [
        'name',
        'email',
        'password',
        'sample_pass'
        // add other columns if needed
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
