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
                    <form id="search-form" method="GET" action="{{ route('product.index') }}" class="mb-4">
    <div class="row g-3 mb-2">
        <div class="col-md-6">
            <input type="text" name="keyword" class="form-control" placeholder="商品名で検索" value="{{ request('keyword') }}">
        </div>
        <div class="col-md-6">
            <select name="company_id" class="form-select">
                <option value="">すべてのメーカー</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" @selected(request('company_id') == $company->id)>
                        {{ $company->company_name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row g-3 mb-2">
        <div class="col-md-6">
            <div class="row g-2">
                <div class="col">
                    <input type="number" name="price_min" class="form-control" placeholder="価格(下限)" value="{{ request('price_min') }}">
                </div>
                <div class="col">
                    <input type="number" name="price_max" class="form-control" placeholder="価格(上限)" value="{{ request('price_max') }}">
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row g-2 align-items-end">
                <div class="col">
                    <input type="number" name="stock_min" class="form-control" placeholder="在庫(下限)" value="{{ request('stock_min') }}">
                </div>
                <div class="col">
                    <input type="number" name="stock_max" class="form-control" placeholder="在庫(上限)" value="{{ request('stock_max') }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">検索</button>
                </div>
                <div class="col-auto">
                    <a href="{{ route('product.index') }}" class="btn btn-secondary">リセット</a>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- 新規追加ボタン --}}
<div class="mb-3 text-end">
    <a href="{{ route('product.create') }}" class="btn btn-warning">新規追加</a>
</div>


                    {{-- 一覧テーブル --}}
                    <div id="product-table">
                        <table id="sortable-table" class="table table-bordered table-hover text-center align-middle tablesorter">
                            <thead class="table-light">
                                <tr>
                                    <th class="header">ID</th>
                                    <th class="header">商品名</th>
                                    <th class="header">メーカー名</th>
                                    <th class="header">価格</th>
                                    <th class="header">在庫数</th>
                                    <th class="sorter-false">画像</th>
                                    <th class="sorter-false">操作</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
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
                                                            <form action="{{ route('product.destroy', $product->id) }}" method="POST" class="delete-form" data-product-id="{{ $product->id }}">
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
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-muted text-center">該当する商品はありません。</td>
                                    </tr>
                                @endforelse
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
    </div>

<script>
    $(function () {
        $('#search-form').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('product.search') }}",
                type: "GET",
                data: $(this).serialize(),
                success: function (response) {
                    const newTable = $(response).find('#product-table').html();
                    $('#product-table').html(newTable);
                    applyTableSorter(); 
                    bindDeleteEvents(); 
                },
                error: function () {
                    alert('検索に失敗しました');
                }
            });
        });

        function applyTableSorter() {
            $('#sortable-table thead th').each(function(index) {
                if (![5, 6].includes(index)) {
                    $(this).addClass('header');
                }
            });
            $('#sortable-table').tablesorter({
                theme: 'bootstrap-5',
                sortList: [[0,1]],
                headers: {
                    5: { sorter: false },
                    6: { sorter: false }
                }
            });
        }

        function bindDeleteEvents() {
    $('.delete-form').off('submit').on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const productId = form.data('product-id');
        const url = form.attr('action');

        $.ajax({
            url: url,
            type: 'POST',
            data: form.serialize(),
            success: function () {
                const modal = $(`#deleteModal${productId}`);
                modal.modal('hide');

                setTimeout(() => {
                    form.closest('tr').remove(); 
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                }, 500);
            },
            error: function () {
                alert('削除に失敗しました');
            }
        });
    });
}

        applyTableSorter();
        bindDeleteEvents();
    });
</script>


</x-app-layout>
