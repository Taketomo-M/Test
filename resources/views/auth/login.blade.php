<x-guest-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h4>ユーザーログイン画面</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">アドレス</label>
                                <input id="email" class="form-control" type="email" name="email" required autofocus />
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">パスワード</label>
                                <input id="password" class="form-control" type="password" name="password" required />
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('register') }}" class="btn btn-warning">新規登録</a>
                                <button type="submit" class="btn btn-info">ログイン</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
