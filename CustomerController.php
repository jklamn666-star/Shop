<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // Import Request
use App\Models\User; // Import User
use Illuminate\Validation\Rule; // Import Rule

class CustomerController extends Controller
{
    /**
     * 1. Hiển thị danh sách khách hàng (index)
     */
    public function index()
    {
        // Lấy tất cả User (khách hàng) và đếm số đơn hàng
        $customers = User::withCount('orders')->get();

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * 2. Hiển thị trang "Xem" (show)
     * (Bao gồm thông tin + lịch sử đơn hàng)
     */
    public function show($id)
    {
        // Lấy 1 User, và tải KÈM THEO tất cả đơn hàng
        $customer = User::with('orders')->findOrFail($id);

        return view('admin.customers.show', compact('customer'));
    }

    /**
     * 3. Hiển thị trang "Sửa" (edit)
     */
    public function edit($id)
    {
        $customer = User::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * 4. Cập nhật thông tin (update)
     */
    public function update(Request $request, $id)
    {
        $customer = User::findOrFail($id);

        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                // Email phải là duy nhất, NGOẠI TRỪ email của chính user này
                Rule::unique('users')->ignore($customer->id), 
            ],
        ]);

        // Cập nhật dữ liệu
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->save(); // Lưu thay đổi

        // Quay lại trang danh sách với thông báo thành công
        return redirect()->route('admin.customers.index')
                        ->with('success', 'Cập nhật thông tin khách hàng thành công!');
    }

    /**
     * 5. Xóa khách hàng (destroy)
     */
    public function destroy($id)
    {
        $customer = User::findOrFail($id);

        // KIỂM TRA AN TOÀN: Nếu khách hàng có đơn hàng, không cho xóa
        if ($customer->orders()->count() > 0) {
            return redirect()->route('admin.customers.edit', $customer->id) // Quay lại trang Sửa
                            ->with('error', 'Không thể xóa khách hàng này vì họ đã có đơn hàng.');
        }

        // Nếu không có đơn hàng, tiến hành xóa
        $customer->delete();

        return redirect()->route('admin.customers.index')
                        ->with('success', 'Xóa khách hàng thành công.');
    }
}