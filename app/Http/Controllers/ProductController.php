<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('company');

        if ($request->filled('keyword')) {
            $query->where('product_name', 'like', '%' . $request->input('keyword') . '%');
        }

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->input('company_id'));
        }

        if ($request->filled('price_min')) {
    $query->where('price', '>=', $request->input('price_min'));
}

if ($request->filled('price_max')) {
    $query->where('price', '<=', $request->input('price_max'));
}

if ($request->filled('stock_min')) {
    $query->where('stock', '>=', $request->input('stock_min'));
}

if ($request->filled('stock_max')) {
    $query->where('stock', '<=', $request->input('stock_max'));
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

public function store(StoreProductRequest $request)
{
    try {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $validated['img_path'] = $path;
        }

        Product::create($validated);

        return redirect()->route('product.index')->with('success', '商品を登録しました');
    } catch (\Exception $e) {
        return back()->withErrors('登録中にエラーが発生しました')->withInput();
    }
}

    public function edit(Product $product)
    {
        $companies = Company::all();
        return view('product.edit', compact('product', 'companies'));
    }

public function update(UpdateProductRequest $request, Product $product)
{
    $validated = $request->validated();

    try {

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
    } catch (\Exception $e) {
        return back()->withInput()->with('error', '更新中にエラーが発生しました: ' . $e->getMessage());
    }
}


    public function destroy(Product $product)
{
    try {
        if ($product->img_path) {
            Storage::disk('public')->delete($product->img_path);
        }

        $product->delete();

        if (request()->ajax()) {
            return response()->json(['message' => '削除成功']);
        }

        return redirect()->route('product.index')->with('success', '商品を削除しました');
    } catch (\Exception $e) {
        if (request()->ajax()) {
            return response()->json(['error' => '削除中にエラーが発生しました'], 500);
        }

        return back()->with('error', '削除中にエラーが発生しました: ' . $e->getMessage());
    }
}


public function show(Product $product)
{
    
    return view('product.show', compact('product'));
}

public function search(Request $request)
{
    $query = Product::with('company');

    if ($request->filled('keyword')) {
        $query->where('product_name', 'like', '%' . $request->input('keyword') . '%');
    }

    if ($request->filled('company_id')) {
        $query->where('company_id', $request->input('company_id'));
    }

    if ($request->filled('price_min')) {
        $query->where('price', '>=', $request->input('price_min'));
    }

    if ($request->filled('price_max')) {
        $query->where('price', '<=', $request->input('price_max'));
    }

    if ($request->filled('stock_min')) {
        $query->where('stock', '>=', $request->input('stock_min'));
    }

    if ($request->filled('stock_max')) {
        $query->where('stock', '<=', $request->input('stock_max'));
    }

    $products = $query->paginate(10)->withQueryString();
    $companies = Company::all();

    return view('product.index', compact('products', 'companies'));
}



}