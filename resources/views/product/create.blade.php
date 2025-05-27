<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
        商品新規登録画面
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8">
                
                {{-- フラッシュメッセージ（登録後用に追加） --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">商品名<span class="text-danger">*</span></label>
                        <input type="text" name="product_name" class="form-control" value="{{ old('product_name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">メーカー名<span class="text-danger">*</span></label>
                        <select name="company_id" class="form-select" required>
                            <option value="">-- 選択してください --</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                    {{ $company->company_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">価格<span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">在庫数<span class="text-danger">*</span></label>
                        <input type="number" name="stock" class="form-control" value="{{ old('stock') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">コメント</label>
                        <textarea name="comment" class="form-control">{{ old('comment') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">商品画像</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="text-start">
                    <button type="submit" class="btn btn-warning">登録</button>
                    <a href="{{ route('product.index') }}" class="btn btn-secondary me-2">戻る</a>
                </div>


                </form>

            </div>
        </div>
    </div>
</x-app-layout>
