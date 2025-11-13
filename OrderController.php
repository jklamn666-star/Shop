<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; // <-- 1. Import Order Model

class OrderController extends Controller
{
    /**
     * Hiển thị danh sách đơn hàng
     */
    public function index()
    {
        // 2. Lấy tất cả đơn hàng, sắp xếp mới nhất lên trên
        $orders = Order::orderBy('created_at', 'desc')->get();

        // 3. Gửi dữ liệu ($orders) tới view
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Hiển thị chi tiết một đơn hàng
     */
    public function show($id)
    {
        // 'with('products')' -> Lấy đơn hàng KÈM THEO các sản phẩm của nó
        $order = Order::with('products')->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Hủy một đơn hàng
     */
    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        // Chỉ cho hủy đơn hàng đang xử lý hoặc đang giao
        if ($order->status == 'Đang xử lý' || $order->status == 'Đang giao') {
            $order->status = 'Đã hủy';
            $order->save();
            return redirect()->route('admin.orders.index')->with('success', 'Đã hủy đơn hàng #SHP'.(1000 + $id));
        }

        return redirect()->route('admin.orders.index')->with('error', 'Không thể hủy đơn hàng này.');
    }
}