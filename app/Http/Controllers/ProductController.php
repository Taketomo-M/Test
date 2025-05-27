<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('company');

        // 検索条件
        if ($request->filled('keyword')) {
            $query->where('product_name', 'like', '%' . $request->input('keyword') . '%');
        }

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->input('company_id'));
        }

        $products = $query->paginate(10);
        $companies = Company::all();

        return view('product.index', compact('products', 'companies'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('product.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'price' => 'required|integer|min:0|max:1000000',
            'stock' => 'required|integer|min:0|max:10000',
            'comment' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $validated['img_path'] = $path;
        }

        Product::create($validated);

        return redirect()->route('product.index')->with('success', '商品を登録しました');
    }

    public function edit(Product $product)
    {
        $companies = Company::all();
        return view('product.edit', compact('product', 'companies'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'price' => 'required|integer|min:0|max:1000000',
            'stock' => 'required|integer|min:0|max:10000',
            'comment' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->has('delete_image') && $product->img_path) {
            Storage::disk('public')->delete($product->img_path);
            $validated['img_path'] = null;
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $validated['img_path'] = $path;
        }

        $product->update($validated);

        return redirect()->route('product.index')->with('success', '商品を更新しました');
    }

    public function destroy(Product $product)
    {
        if ($product->img_path) {
            Storage::disk('public')->delete($product->img_path);
        }
        $product->delete();
        return redirect()->route('product.index')->with('success', '商品を削除しました');
    }

    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }
}