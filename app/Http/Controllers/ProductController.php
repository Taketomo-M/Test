<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    $query = Product::with('company');

if ($request->filled('keyword')) {
    $query->where('name', 'like', '%' . $request->input('keyword') . '%');
}

if ($request->filled('company_id')) {
    $query->where('company_id', $request->input('company_id'));
}

$sortable = ['id', 'price', 'stock'];
$sort = $request->input('sort');
$direction = $request->input('direction') === 'desc' ? 'desc' : 'asc';

if (in_array($sort, $sortable)) {
    $query->orderBy($sort, $direction);
} else {
    $query->orderBy('id', 'asc');
}


    $products = $query->paginate(10);

    $companies = Company::all();

    return view('product.index', compact('products', 'companies'));


}

    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
{
    $companies = Company::all();
    return view('product.create', compact('companies'));
}

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'price' => 'required|integer|min:0|max:1000000',
            'stock' => 'required|integer|min:0|max:10000',
            'comment' => 'nullable|string|max:1000', 
            'image' => 'nullable|image|max:2048',
        ], [
            'name.required' => '商品名は必須です。',
            'name.max' => '商品名は255文字以内で入力してください。',
            'company_id.required' => 'メーカーを選択してください。',
            'company_id.exists' => '選択されたメーカーが無効です。',
            'price.required' => '価格は必須です。',
            'price.integer' => '価格は整数で入力してください。',
            'price.min' => '価格は0円以上で入力してください。',
            'price.max' => '価格は100万円以下で入力してください。',
            'stock.required' => '在庫は必須です。',
            'stock.integer' => '在庫は整数で入力してください。',
            'stock.min' => '在庫は0以上で入力してください。',
            'stock.max' => '在庫は10000以下で入力してください。',
            'comment.max' => 'コメントは1000文字以内で入力してください。',
            'image.image' => '画像ファイルを選択してください。',
            'image.max' => '画像ファイルのサイズは2MB以下にしてください。',
        ]);
        
    
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $validated['image_path'] = $path;
        }
    
        Product::create($validated);
    
        return redirect()->route('product.index')->with('success', '登録が完了しました');
    }
    


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
{
    return view('product.show', compact('product'));
}


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
{
    $companies = \App\Models\Company::all();
    return view('product.edit', compact('product', 'companies'));
}



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'company_id' => 'required|exists:companies,id',
        'price' => 'required|integer|min:0|max:1000000',
        'stock' => 'required|integer|min:0|max:10000',
        'comment' => 'nullable|string|max:1000', 
        'image' => 'nullable|image|max:2048',
    ], [
        'name.required' => '商品名は必須です。',
        'name.max' => '商品名は255文字以内で入力してください。',
        'company_id.required' => 'メーカーを選択してください。',
        'company_id.exists' => '選択されたメーカーが無効です。',
        'price.required' => '価格は必須です。',
        'price.integer' => '価格は整数で入力してください。',
        'price.min' => '価格は0円以上で入力してください。',
        'price.max' => '価格は100万円以下で入力してください。',
        'stock.required' => '在庫は必須です。',
        'stock.integer' => '在庫は整数で入力してください。',
        'stock.min' => '在庫は0以上で入力してください。',
        'stock.max' => '在庫は10000以下で入力してください。',
        'comment.max' => 'コメントは1000文字以内で入力してください。',
        'image.image' => '画像ファイルを選択してください。',
        'image.max' => '画像ファイルのサイズは2MB以下にしてください。',
    ]);
    


    if ($request->has('delete_image') && $product->image_path) {
        \Storage::disk('public')->delete($product->image_path);
        $validated['image_path'] = null;
    }

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('images', 'public');
        $validated['image_path'] = $path;
    }
    
    $product->update($validated);

    return redirect()->route('product.index')->with('success', '更新が完了しました');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
{
    $product->delete();
    return redirect()->route('product.index')->with('success', '削除が完了しました');
}

}
