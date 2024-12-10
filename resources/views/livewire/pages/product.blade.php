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
                                @forelse($products as $product)
                                <div class="bg-white rounded-lg shadow">
                                    <img src="{{ $product->gambar ? Storage::url($product->gambar) : 'https://via.placeholder.com/150' }}" class="w-full h-40 object-cover rounded-t-lg" alt="{{ $product->nama_produk }}">
                                    <div class="p-4">
                                        <h6 class="font-semibold">{{ $product->nama_produk }}</h6>
                                        <p class="text-gray-600">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                                        <div class="flex space-x-2 mt-2">
                                            <button class="flex-1 px-3 py-1 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700" wire:click="edit({{ $product->id }})">
                                                Edit
                                            </button>
                                            <button class="flex-1 px-3 py-1 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700" wire:click="delete({{ $product->id }})">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <p class="text-gray-500">No products found.</p>
                                @endforelse
                            </div>
                            
                            <!-- Loading State -->
                            <div wire:loading class="text-center text-blue-500 mt-4">
                                Loading products...
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Right Column - Add/Edit Product -->
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-4 border-b">
                            <h4 class="text-xl font-semibold">{{ $isEdit ? 'Edit Product' : 'Add Product' }}</h4>
                        </div>
                        <div class="p-4">
                            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'saveProduct' }}">
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
                                    <div class="flex space-x-2">
                                        <select wire:model="id_kategori" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" wire:poll>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                                            @endforeach
                                        </select>
                                        @livewire('components.modal-category')
                                    </div>
                                </div>

                                <div class="mb-4" style="display: none;">
                                    <label class="block text-sm font-medium text-gray-700">Toko</label>
                                    <input type="hidden" wire:model="id_toko" value="{{ auth()->user()->id_toko }}">
                                </div>

                                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700" wire:loading.attr="disabled">
                                    <span wire:loading.remove>{{ $isEdit ? 'Update Product' : 'Save Product' }}</span>
                                    <span wire:loading>Processing...</span>
                                </button>
                            </form>
                            @if (session('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    @endsection
</div>