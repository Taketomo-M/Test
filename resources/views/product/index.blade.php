
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            商品一覧画面
        </h2>
    </x-slot>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <!-- 検索フォーム + 新規登録ボタン -->
                <div class="mb-3 d-flex align-items-center">
                    <form method="GET" action="{{ route('product.index') }}" class="d-flex flex-wrap gap-2">
                        <input type="text" name="keyword" class="form-control" placeholder="検索キーワード" value="{{ request('keyword') }}">
                        <select name="company_id" class="form-select">
                            <option value="">メーカー名</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">検索</button>
                    </form>

                    <div class="ms-auto">
                        <a href="{{ route('product.create') }}" class="btn btn-warning">新規登録</a>
                    </div>
                </div>

                <!-- 商品テーブル -->
                <table class="table table-bordered table-striped align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>商品画像</th>
                            <th>商品名</th>
                            <th>価格</th>
                            <th>在庫数</th>
                            <th>メーカー名</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                @if ($product->image_path)
                                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="画像" width="60">
                                @else
                                    画像なし
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>¥{{ number_format($product->price) }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->company->name }}</td>
                            <td class="d-flex justify-content-center gap-2">
                                <a href="{{ route('product.show', $product->id) }}" class="btn btn-info btn-sm">詳細</a>
                                <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                                      onsubmit="return confirm('本当に削除しますか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">削除</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- ページネーション -->
                <div class="d-flex justify-content-center">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
