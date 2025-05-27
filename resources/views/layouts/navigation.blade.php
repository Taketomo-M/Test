<nav class="bg-white border-b border-gray-100 px-6 py-3">
    <div class="max-w-7xl mx-auto flex justify-end">
        <!-- ログアウト -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-gray-800 font-semibold hover:underline">
                ログアウト
            </button>
        </form>
    </div>
</nav>
