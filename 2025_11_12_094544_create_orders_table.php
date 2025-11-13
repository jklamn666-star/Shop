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
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Mã đơn hàng (sẽ được format sau)

            $table->string('customer_name'); // Tên khách hàng
            $table->decimal('total_amount', 15, 2); // Tổng tiền

            // Trạng thái (sẽ là: Đã giao, Đang xử lý, Đang giao, Đã hủy)
            $table->string('status')->default('Đang xử lý'); 

            // Cột 'created_at' sẽ được dùng cho "Ngày đặt"
            $table->timestamps(); 
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
