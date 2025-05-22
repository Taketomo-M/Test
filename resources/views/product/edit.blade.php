<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            商品情報編集画面
        </h2>
    </x-slot>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">
                        <form method="POST" action="{{ route('product.update', $product->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label"><strong>ID：</strong></label>
                                <div>{{ $product->id }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">商品名 <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="company_id" class="form-label">メーカー名 <span class="text-danger">*</span></label>
                                <select name="company_id" id="company_id" class="form-select" required>
                                    <option value="">選択してください</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ old('company_id', $product->company_id) == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">価格 <span class="text-danger">*</span></label>
                                <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="stock" class="form-label">在庫数 <span class="text-danger">*</span></label>
                                <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="comment" class="form-label">コメント</label>
                                <textarea name="comment" id="comment" class="form-control" rows="3">{{ old('comment', $product->comment) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">商品画像</label>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-warning">更新</button>
                                <a href="{{ route('product.show', $product->id) }}" class="btn btn-info">戻る</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
