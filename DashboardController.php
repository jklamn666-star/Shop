<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageVisit; // Import model Lượt truy cập
use App\Models\Order;     // Import model Đơn hàng
use App\Models\User;      // Import model User (Khách hàng)
use Carbon\Carbon;        // Import Carbon để xử lý ngày tháng

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Lấy ngày hôm nay
        $today = Carbon::today();
        $formattedDate = $today->format('d/m/Y'); // Format "ngày/tháng/năm"

        // 2. TÍNH TOÁN 4 THẺ THÔNG TIN

        // Thẻ 1: Doanh thu hôm nay
        $todayRevenue = Order::whereDate('created_at', $today)->sum('total_amount');

        // Thẻ 2: Đơn hàng mới hôm nay
        $todayOrders = Order::whereDate('created_at', $today)->count();

        // Thẻ 3: Khách hàng mới hôm nay
        $todayCustomers = User::whereDate('created_at', $today)->count();

        // Thẻ 4: Lượt truy cập hôm nay
        $visitCount = PageVisit::whereDate('created_at', $today)->count();

        // 3. Trả về view với tất cả dữ liệu
        return view('admin.dashboard', compact(
            'formattedDate',
            'todayRevenue',
            'todayOrders',
            'todayCustomers',
            'visitCount'
        ));
    }
}