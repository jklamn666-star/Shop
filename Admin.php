<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable 
{
    use HasFactory, Notifiable;

    /**
     * Chỉ định guard (bảo vệ) riêng cho Admin
     */
    protected $guard = 'admin';

    /**
     * Các trường được phép điền
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Các trường bị ẩn khi trả về JSON
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}