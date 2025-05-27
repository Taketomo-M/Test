<x-guest-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10"> 
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h4>ユーザー新規登録画面</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            {{-- ユーザー名 --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">ユーザー名</label>
                                <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required />
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- アドレス --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">アドレス</label>
                                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required />
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- パスワード --}}
                            <div class="mb-3">
                                <label for="password" class="form-label">パスワード</label>
                                <input id="password" class="form-control" type="password" name="password" required />
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- パスワード確認 --}}
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">パスワード（確認）</label>
                                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required />
                            </div>

                            {{-- ボタン --}}
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('login') }}" class="btn btn-info w-50 me-2">戻る</a>
                                <button type="submit" class="btn btn-warning w-50">新規登録</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
