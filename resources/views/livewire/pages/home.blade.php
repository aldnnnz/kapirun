
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
                            <h4 class="text-xl font-semibold">Shopping Cart</h4>
                        </div>
                        <div class="p-4">
                            @php
                            $dummyCart = [
                                ['id' => 1, 'name' => 'Product 1', 'price' => 150000, 'quantity' => 2],
                                ['id' => 2, 'name' => 'Product 2', 'price' => 200000, 'quantity' => 1],
                            ];
                            $total = array_sum(array_map(function($item) {
                                return $item['price'] * $item['quantity'];
                            }, $dummyCart));
                            @endphp

                            @if(count($dummyCart) > 0)
                                @foreach($dummyCart as $item)
                                <div class="flex justify-between items-center mb-4">
                                    <div>
                                        <h6 class="font-semibold">{{ $item['name'] }}</h6>
                                        <small class="text-gray-600">Rp {{ number_format($item['price'], 0, ',', '.') }}</small>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <button class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300" wire:click="decrementQuantity({{ $item['id'] }})">-</button>
                                        <span>{{ $item['quantity'] }}</span>
                                        <button class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300" wire:click="incrementQuantity({{ $item['id'] }})">+</button>
                                        <button class="p-1 text-red-600 hover:text-red-800" wire:click="removeFromCart({{ $item['id'] }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                                <hr class="my-4">
                                <div class="flex justify-between mb-4">
                                    <h5 class="font-semibold">Total:</h5>
                                    <h5 class="font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</h5>
                                </div>
                                <button class="w-full px-3 py-1 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700" wire:click="checkout">
                                    Proceed to Checkout
                                </button>
                            @else
                                <p class="text-center text-gray-600">Your cart is empty</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    @endsection
</div>