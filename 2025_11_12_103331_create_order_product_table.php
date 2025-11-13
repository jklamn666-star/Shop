<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_product', function (Blueprint $table) {
        $table->id();

        // 2 khóa ngoại liên kết 2 bảng
        $table->foreignId('order_id')->constrained()->onDelete('cascade');
        $table->foreignId('product_id')->constrained()->onDelete('cascade');

        // Các thông tin bổ sung
        $table->integer('quantity'); // Khách mua bao nhiêu sản phẩm này
        $table->decimal('price', 15, 2); // Giá của sản phẩm TẠI THỜI ĐIỂM MUA

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};
