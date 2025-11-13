<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Cho phép các cột này được điền vào khi 'Thêm sản phẩm'
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'image',
        'category',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')
                    ->withPivot('quantity', 'price');
    }
}
