<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    
        <div class="container mx-auto px-4 py-8">
            <div class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-4">
                @foreach($produk as $item)
                <!-- Product Card -->
                <div class="break-inside-avoid mb-4 bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ $item->gambar ?? 'https://via.placeholder.com/300x200' }}" alt="{{ $item->name }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2">{{ $item->name }}</h3>
                        <p class="text-gray-600 text-sm mb-2">{{ $item->description }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-indigo-600 font-bold">Rp {{ number_format($item->price, 2, ',', '.') }}</span>
                            <button class="bg-indigo-600 text-white px-3 py-1 rounded-md text-sm hover:bg-indigo-700">Add to Cart</button>
                        </div>
                        <div class="mt-2 text-xs text-gray-500">
                            <p>Stock: {{ $item->stock }}</p>
                            <p>Kategori: {{ $item->kategori->name ?? 'N/A' }}</p>
                            <p>Toko: {{ $item->toko->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    
</body>
</html>