<x-guest-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10"> {{-- 横幅をもっと広く --}}
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h4>ユーザーログイン画面</h4>
                    </div>
                    <div class="card-body">
                        {{-- フラッシュメッセージ --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="閉じる"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">アドレス</label>
                                <input id="email" class="form-control form-control-lg" type="email" name="email" required autofocus />
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">パスワード</label>
                                <input id="password" class="form-control form-control-lg" type="password" name="password" required />
                            </div>

                            <div class="d-flex gap-2">
    <a href="{{ route('register') }}" class="btn btn-warning flex-grow-1 text-nowrap">新規登録</a>
    <button type="submit" class="btn btn-info flex-grow-1 text-nowrap">ログイン</button>
</div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
