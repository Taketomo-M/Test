<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            商品情報詳細画面
        </h2>
    </x-slot>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">

                        <div class="mb-3 text-center">
                            <strong>ID：</strong> {{ $product->id }}
                        </div>

                        <div class="mb-3 text-center">
                            <strong>商品画像：</strong><br>
                            @if ($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="商品画像" width="150">
                            @else
                                画像なし
                            @endif
                        </div>

                        <div class="mb-3">
                            <strong>商品名：</strong> {{ $product->name }}
                        </div>

                        <div class="mb-3">
                            <strong>メーカー：</strong> {{ $product->company->name }}
                        </div>

                        <div class="mb-3">
                            <strong>価格：</strong> ¥{{ number_format($product->price) }}
                        </div>

                        <div class="mb-3">
                            <strong>在庫数：</strong> {{ $product->stock }}
                        </div>

                        <div class="mb-3">
                            <strong>コメント：</strong><br>
                            <textarea class="form-control" rows="3" readonly>{{ $product->comment }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-warning">編集</a>
                            <a href="{{ route('product.index') }}" class="btn btn-info">戻る</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

