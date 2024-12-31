<div>
    @section('content')
    <div class="p-4 rounded-lg">
        <div>
            @if (session()->has('message'))
                <div class="p-2 bg-green-100 text-green-600 rounded mb-2">
                    {{ session('message') }}
                </div>
            @endif
            
            @if (session()->has('error'))
                <div class="p-2 bg-red-100 text-red-600 rounded mb-2">
                    {{ session('error') }}
                </div>
            @endif
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
            <!-- Left Column - Product List -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-lg shadow">
                    <div class="p-4 border-b">
                        <h4 class="text-xl font-semibold">Products</h4>
                        <div class="mt-3 flex">
                            <input type="text" class="flex-1 rounded-l-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Search products..." wire:model.live="search">
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
                        <form wire:submit="saveProduct">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Kode</label>
                                <input type="text" wire:model="kode" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                @error('kode') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                                <input type="text" wire:model="nama_produk" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" maxlength="100" required>
                                @error('nama_produk') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Harga</label>
                                <input type="number" wire:model="harga" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" min="0" required>
                                @error('harga') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Stok</label>
                                <input type="number" wire:model="stok" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" min="0" required>
                                @error('stok') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Gambar</label>
                                <input type="file" wire:model="gambar" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" accept="image/*">
                                @if ($gambar && !$errors->has('gambar'))
                                    <img src="{{ $gambar->temporaryUrl() }}" alt="Preview" class="w-32 h-32 object-cover rounded-lg mt-2">
                                @endif
                                @error('gambar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <div wire:loading wire:target="gambar" class="text-sm text-gray-500 mt-1">Uploading...</div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                <div class="flex space-x-2">
                                    <select wire:model="id_kategori" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" >
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_kategori') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    @livewire('components.modal-category')
                                </div>
                            </div>

                            <input type="hidden" wire:model="id_toko" value="{{ auth()->user()->id_toko }}">

                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700" wire:loading.attr="disabled" wire:target="saveProduct" wire:loading.class="bg-blue-400">
                                <span wire:loading.remove wire:target="saveProduct">{{ $isEdit ? 'Update Product' : 'Add Product' }}</span>
                                <span wire:loading wire:target="saveProduct">Processing...</span>
                            </button>

                            <!-- Tambahan indikator submit -->
                            <!-- <div class="mt-2">
                                <div wire:loading wire:target="saveProduct" class="text-center text-blue-500">
                                    <i class="fas fa-spinner fa-spin"></i> Submitting form...
                                </div>
                                <div wire:loading.remove wire:target="saveProduct">
                                    @if (session()->has('message'))
                                        <div class="text-center text-green-500">
                                            <i class="fas fa-check-circle"></i> Form submitted successfully!
                                        </div>
                                    @endif
                                </div>
                            </div> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection 
</div>