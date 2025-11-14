<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Menu
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('foodmenu.update', $foodMenu->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <label for="name">Nama Menu</label>
                        <input type="text" name="name" id="name" value="{{ $foodMenu->name }}">
                        <br>
                        <label for="description">Deskripsi</label>
                        <textarea name="description" id="description">{{ $foodMenu->description }}</textarea>
                        <br>
                        <label for="price">Harga</label>
                        <input type="number" name="price" id="price" step="0.01" value="{{ $foodMenu->price }}">
                        <br>
                        <label for="image">Gambar</label>
                        <input type="file" name="image" id="image">
                        <br>
                        <button style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px;" type="submit">Update Menu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
