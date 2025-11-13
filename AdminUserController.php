<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    /**
     * Hiển thị danh sách TẤT CẢ tài khoản Admin
     */
    public function index()
    {
        // Lấy tất cả user từ bảng 'admins'
        $admins = Admin::all(); 
        return view('admin.users.index', compact('admins'));
    }

    /**
     * Hiển thị form tạo admin mới
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Lưu admin mới vào database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins', // Kiểm tra bảng 'admins'
            'password' => 'required|string|min:8|confirmed',
        ]);

        Admin::create([ // Tạo trong Model 'Admin'
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Tạo tài khoản Admin thành công.');
    }

    /**
     * Hiển thị form chỉnh sửa admin
     */
    public function edit($id)
    {
        $admin = Admin::findOrFail($id); // Lấy từ Model 'Admin'
        return view('admin.users.edit', compact('admin'));
    }

    /**
     * Cập nhật thông tin admin
     */
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id); // Lấy từ Model 'Admin'

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('admins')->ignore($admin->id), // Kiểm tra bảng 'admins'
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật tài khoản Admin thành công.');
    }

    /**
     * Xóa tài khoản admin
     */
    public function destroy($id)
    {
        // Không cho Admin tự xóa chính mình
        if (Auth::guard('admin')->id() == $id) { 
            return redirect()->route('admin.users.index')->with('error', 'Bạn không thể tự xóa tài khoản của chính mình.');
        }
        
        $admin = Admin::findOrFail($id); // Lấy từ Model 'Admin'
        $admin->delete();

        return redirect()->route('admin.users.index')->with('success', 'Xóa tài khoản Admin thành công.');
    }
}