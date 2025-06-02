<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
        商品情報編集画面
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">

                {{-- 成功メッセージ --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="閉じる"></button>
                    </div>
                @endif

                {{-- バリデーションエラー --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="閉じる"></button>
                    </div>
                @endif

                <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">商品名<span class="text-danger">*</span></label>
                        <input type="text" name="product_name" class="form-control" value="{{ old('product_name', $product->product_name) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">メーカー名<span class="text-danger">*</span></label>
                        <select name="company_id" class="form-select">
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}" {{ $company->id == old('company_id', $product->company_id) ? 'selected' : '' }}>
                                    {{ $company->company_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">価格<span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">在庫数<span class="text-danger">*</span></label>
                        <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">コメント</label>
                        <textarea name="comment" class="form-control" rows="3">{{ old('comment', $product->comment) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">現在の画像</label><br>
@if ($product->img_path)
    <img src="{{ asset('storage/' . $product->img_path) }}" alt="商品画像" class="img-thumbnail mb-2" width="200">
    
    {{-- 画像削除用の hidden + checkbox --}}
    <input type="hidden" name="delete_image" value="0">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="delete_image" value="1" id="deleteImage">
        <label class="form-check-label" for="deleteImage">画像を削除する</label>
    </div>
@else
    <p>画像なし</p>
@endif


                    <div class="mb-3">
                        <label class="form-label">画像を変更する</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">更新する</button>
                    <a href="{{ route('product.show', $product->id) }}" class="btn btn-secondary">戻る</a>

</div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
