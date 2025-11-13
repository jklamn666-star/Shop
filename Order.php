<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Cho phép các trường này được điền
    protected $fillable = [
        'customer_name',
        'total_amount',
        'status',
    ];

    public function products()
    {
        // (1) Quan hệ "Nhiều-Nhiều"
        // (2) Tên bảng trung gian là 'order_product'
        // (3) Lấy thêm 2 cột 'quantity' và 'price' từ bảng trung gian
        return $this->belongsToMany(Product::class, 'order_product')
                    ->withPivot('quantity', 'price');
    }
    public function user()
    {
        // Một Order (Đơn hàng) thuộc về một User (Khách hàng)
        return $this->belongsTo(User::class);
    }
}