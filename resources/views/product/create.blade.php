<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            商品新規登録
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @include('partials.messages')

                    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block font-medium text-sm text-gray-700">商品名</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-input rounded-md shadow-sm mt-1 block w-full @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="company_id" class="block font-medium text-sm text-gray-700">メーカー</label>
                            <select name="company_id" id="company_id" class="form-select rounded-md shadow-sm mt-1 block w-full @error('company_id') border-red-500 @enderror">
                                <option value="">選択してください</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('company_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="price" class="block font-medium text-sm text-gray-700">価格</label>
                            <input type="number" id="price" name="price" value="{{ old('price') }}" class="form-input rounded-md shadow-sm mt-1 block w-full @error('price') border-red-500 @enderror">
                            @error('price')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="stock" class="block font-medium text-sm text-gray-700">在庫</label>
                            <input type="number" id="stock" name="stock" value="{{ old('stock') }}" class="form-input rounded-md shadow-sm mt-1 block w-full @error('stock') border-red-500 @enderror">
                            @error('stock')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="comment" class="block font-medium text-sm text-gray-700">コメント</label>
                            <textarea id="comment" name="comment" class="form-input rounded-md shadow-sm mt-1 block w-full @error('comment') border-red-500 @enderror">{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block font-medium text-sm text-gray-700">商品画像</label>
                            <input type="file" id="image" name="image" class="form-input rounded-md shadow-sm mt-1 block w-full @error('image') border-red-500 @enderror">
                            @error('image')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-center mt-6">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">登録</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
