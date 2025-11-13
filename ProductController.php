<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product-detail', compact('product'));
    }

    public function byCategory($slug)
    {
        $categoryName = match ($slug) {
            'dien-thoai' => 'Điện thoại',
            'laptop-phu-kien', 'laptop', 'phu-kien' => 'Laptop / Phụ kiện',
            default => null,
        };

        if (!$categoryName) {
            abort(404);
        }

        $products = Product::where('category', $categoryName)->get();

        return view('category', [
            'products' => $products,
            'category' => $categoryName
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->get();

        return view('search-results', [
            'query' => $query,
            'products' => $products,
        ]);
    }
}
