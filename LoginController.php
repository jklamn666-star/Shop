<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth
use App\Providers\RouteServiceProvider; // (Tùy chọn, cho chuyển hướng)

class LoginController extends Controller
{
    /**
     * 1. Hiển thị form đăng nhập cho Admin.
     */
    public function showLoginForm()
    {
        // Nếu admin đã đăng nhập rồi, ném về dashboard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.auth.login'); // Trả về view form login
    }

    /**
     * 2. Xử lý logic khi Admin bấm nút "Đăng nhập".
     */
    public function login(Request $request)
    {
        // Kiểm tra dữ liệu
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Thử đăng nhập bằng guard 'admin'
        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
            // Nếu thành công
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        // Nếu thất bại
        return back()->withErrors([
            'email' => 'Sai email hoặc mật khẩu.',
        ])->onlyInput('email');
    }

    /**
     * 3. Xử lý logic khi Admin bấm "Đăng xuất".
     * (ĐÃ SỬA: Chuyển hướng về Trang chủ)
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Sửa thành 'home' để nhảy về trang chủ (theo yêu cầu)
        return redirect()->route('home'); 
    }
}