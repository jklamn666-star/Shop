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
        Schema::table('orders', function (Blueprint $table) {
        // Thêm cột user_id (khóa ngoại)
        // 'nullable' -> chấp nhận đơn hàng cũ (chưa có user_id)
        // 'after' -> đặt cột này sau cột 'id' cho đẹp
        $table->foreignId('user_id')->nullable()->after('id')->constrained('users');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
