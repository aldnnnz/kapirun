
<div>
    @section('content')
    
        <div class="p-4 rounded-lg">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
                <!-- Left Column - Product List -->
                <div class="lg:col-span-8">
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-4 border-b">
                            <h4 class="text-xl font-semibold">Products</h4>
                            <div class="mt-3 flex">
                                <input type="text" class="flex-1 rounded-l-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Search products..." wire:model="search">
                                <button class="px-4 py-2 bg-gray-100 border border-l-0 border-gray-300 rounded-r-lg hover:bg-gray-200">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @php
                                $dummyProducts = [
                                    ['id' => 1, 'name' => 'Product 1', 'price' => 150000, 'image_url' => 'https://via.placeholder.com/150'],
                                    ['id' => 2, 'name' => 'Product 2', 'price' => 200000, 'image_url' => 'https://via.placeholder.com/150'],
                                    ['id' => 3, 'name' => 'Product 3', 'price' => 175000, 'image_url' => 'https://via.placeholder.com/150'],
                                    ['id' => 4, 'name' => 'Product 4', 'price' => 300000, 'image_url' => 'https://via.placeholder.com/150'],
                                ];
                                @endphp

                                @foreach($dummyProducts as $product)
                                <div class="bg-white rounded-lg shadow">
                                    <img src="{{ $product['image_url'] }}" class="w-full h-40 object-cover rounded-t-lg" alt="{{ $product['name'] }}">
                                    <div class="p-4">
                                        <h6 class="font-semibold">{{ $product['name'] }}</h6>
                                        <p class="text-gray-600">Rp {{ number_format($product['price'], 0, ',', '.') }}</p>
                                        <button class="w-full mt-2 px-3 py-1 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700" wire:click="addToCart({{ $product['id'] }})">
                                            Add to Cart
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Right Column - Cart -->
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-4 border-b">
                            <h4 class="text-xl font-semibold">Add Product</h4>
                        </div>
                        <div class="p-4">
                            <form wire:submit.prevent="saveProduct">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Kode</label>
                                    <input type="text" wire:model="kode" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                                    <input type="text" wire:model="nama_produk" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" maxlength="100" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Harga</label>
                                    <input type="number" wire:model="harga" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" min="0" required>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Stok</label>
                                    <input type="number" wire:model="stok" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" min="0" required>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Gambar</label>
                                    <input type="file" wire:model="gambar" class="mt-1 block w-full rounded-xl" accept="image/*">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                    <select wire:model="id_kategori" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select Category</option>
                                        @php
                                        $dummyCategories = [
                                            ['id' => 1, 'name' => 'Electronics'],
                                            ['id' => 2, 'name' => 'Fashion'],
                                            ['id' => 3, 'name' => 'Food & Beverage'],
                                        ];
                                        @endphp
                                        @foreach($dummyCategories as $category)
                                            <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700">
                                    Save Product
                                </button>
                            </form>                        </div>                    </div>
                </div>            </div>
        </div>    
    @endsection
</div>