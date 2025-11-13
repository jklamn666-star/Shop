<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'description', 'image', 'category'];

        public function getImageUrlAttribute()
    {
        $folder = match ($this->category) {
            'Laptop / Phụ kiện' => 'laptop và tai nghe',
            'Điện thoại' => 'product-image',
            default => 'product-image'
        };

        if (empty($this->attributes['image'])) {
            return asset("images/placeholder.jpg"); // Ảnh dự phòng nếu trống
        }

        return asset("{$folder}/{$this->attributes['image']}");
    }
}



