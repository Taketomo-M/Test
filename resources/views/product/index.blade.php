<x-app-layout>
    {{-- ページタイトル --}}
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
    商品情報一覧画面
    </h2>
</x-slot>


    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- フラッシュメッセージ --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="閉じる"></button>
                        </div>
                    @endif

                    {{-- 検索フォーム --}}
                    <form method="GET" action="{{ route('product.index') }}" class="row g-3 mb-4">
                        <div class="col-md-5">
                            <input type="text" name="keyword" class="form-control" placeholder="商品名で検索" value="{{ request('keyword') }}">
                        </div>
                        <div class="col-md-4">
                            <select name="company_id" class="form-select">
                                <option value="">すべてのメーカー</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}" @selected(request('company_id') == $company->id)>
                                        {{ $company->company_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">検索</button>
                            <a href="{{ route('product.index') }}" class="btn btn-secondary">リセット</a>
                        </div>
                    </form>


                    {{-- 新規登録ボタン --}}
                    <div class="mb-3 text-end">
                        <a href="{{ route('product.create') }}" class="btn btn-warning">新規追加</a>
                    </div>

                    {{-- 一覧テーブル --}}
                    <table class="table table-bordered table-hover text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>商品名</th>
                                <th>メーカー名</th>
                                <th>価格</th>
                                <th>在庫数</th>
                                <th>画像</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->company->company_name ?? '未設定' }}</td>
                                    <td>{{ number_format($product->price) }}円</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        @if ($product->img_path)
                                            <img src="{{ asset('storage/' . $product->img_path) }}" alt="画像" width="60">
                                        @else
                                            画像なし
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('product.show', $product->id) }}" class="btn btn-success btn-sm">詳細</a>
                                        <!-- 削除ボタン -->
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $product->id }}">
                                            削除
                                        </button>

                                        <!-- モーダル -->
                                        <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $product->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalLabel{{ $product->id }}">削除確認</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        商品「{{ $product->product_name }}」を本当に削除しますか？
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('product.destroy', $product->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                                            <button type="submit" class="btn btn-danger">削除する</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- ページネーション --}}
                    <div class="mt-4">
                        {{ $products->appends(request()->query())->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
