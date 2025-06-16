<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;

class SalesController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $product = Product::find($validated['product_id']);

    if ($product->stock === 0) {
        return response()->json([
            'error' => 'この商品は在庫切れです。'
        ], 400);
    }

    if ($product->stock < $validated['quantity']) {
        return response()->json([
            'error' => '在庫が不足しています。現在の在庫数：' . $product->stock
        ], 400);
    }

    try {
        \DB::beginTransaction();

        $product->decrement('stock', $validated['quantity']);

        Sale::create([
            'product_id' => $product->id,
            'quantity' => $validated['quantity'],
        ]);

        \DB::commit();

        return response()->json([
            'message' => '購入処理が完了しました。',
            'remaining_stock' => $product->fresh()->stock
        ]);
    } catch (\Exception $e) {
        \DB::rollBack();

        return response()->json([
            'error' => '購入処理中にエラーが発生しました。'
        ], 500);
    }
}
}
