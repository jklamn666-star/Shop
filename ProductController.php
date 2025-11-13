<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; 

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm
     */
    public function index()
    {
        $products = Product::all(); 
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        // Chỉ cần trả về view có chứa form
        return view('admin.products.create');
    }

    /**
     * (HÀM MỚI)
     * Lưu sản phẩm mới vào database
     */
    public function store(Request $request)
    {
        // 1. Validation (Kiểm tra dữ liệu)
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'category' => 'required|string|in:Điện thoại,Laptop,Phụ kiện',
    
        ]);

        // 2. Tạo sản phẩm mới từ dữ liệu
        // (Sử dụng $fillable trong Model)
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'category' => $request->category,
        ]);

        // 3. Quay trở lại trang danh sách với thông báo thành công
        return redirect()->route('admin.products.index')
                         ->with('success', 'Thêm sản phẩm thành công!');
    }
   
}