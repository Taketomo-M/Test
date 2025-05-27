<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
        商品情報詳細画面
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">商品情報</h5>
                    <div class="d-flex justify-content-start mt-4">
    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary me-2">編集</a>
    <a href="{{ route('product.index') }}" class="btn btn-secondary">戻る</a>
</div>

                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
    <li class="list-group-item"><strong>商品名：</strong>{{ $product->product_name }}</li>
    @if ($product->img_path)
        <li class="list-group-item">
            <strong>商品画像：</strong><br>
            <img src="{{ asset('storage/' . $product->img_path) }}" alt="商品画像" class="img-fluid mb-3" style="max-width: 300px;">
        </li>
    @else
        <li class="list-group-item"><strong>商品画像：</strong>画像なし</li>
    @endif
    <li class="list-group-item"><strong>メーカー名：</strong>{{ $product->company->company_name ?? '未登録' }}</li>
    <li class="list-group-item"><strong>価格：</strong>{{ number_format($product->price) }} 円</li>
    <li class="list-group-item"><strong>在庫数：</strong>{{ $product->stock }} 個</li>
    <li class="list-group-item"><strong>コメント：</strong><br>{{ $product->comment ?: 'なし' }}</li>
</ul>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
