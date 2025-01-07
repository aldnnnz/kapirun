<?php
namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Toko;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Home extends Component
{
    public $products = [];
    public $cart = [];
    public $total = 0;
    public $search = '';

    public function mount()
    {
        // Ambil data produk dengan kolom yang sesuai
        $this->products = Produk::where('id_toko', Auth::id())->get();     
        
        $this->cart = session('cart', []);

        $this->calculateTotal();
    }

    public function addToCart($productId)
    {
        $product = Produk::findOrFail($productId);

        // Cek apakah produk sudah ada di keranjang
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
        } else {
            $this->cart[$productId] = [
                'id' => $product->id,
                'nama_produk' => $product->nama_produk,
                'harga' => $product->harga,
                'quantity' => 1,
            ];
        }

        // Simpan keranjang ke session
        session(['cart' => $this->cart]);

        // Hitung ulang total
        $this->calculateTotal();

        // Emit event untuk memperbarui UI
        $this->dispatch('cartUpdated');
    }

    public function incrementQuantity($productId)
    {
        // Cek apakah produk ada di keranjang
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
            session(['cart' => $this->cart]);

            // Hitung ulang total
            $this->calculateTotal();

            // Emit event untuk memperbarui UI
            $this->dispatch('cartUpdated');
        }
    }

    public function removeFromCart($productId)
    {
        if (isset($this->cart[$productId])) {
            unset($this->cart[$productId]);
            session(['cart' => $this->cart]);

            $this->calculateTotal();

            $this->dispatch('cartUpdated');
        }
    }

    public function decrementQuantity($productId)
    {
        // Cek apakah produk ada di keranjang
        if (isset($this->cart[$productId])) {
            if ($this->cart[$productId]['quantity'] > 1) {
                $this->cart[$productId]['quantity']--;
            } else {
                unset($this->cart[$productId]);
            }
            session(['cart' => $this->cart]);

            // Hitung ulang total
            $this->calculateTotal();

            // Emit event untuk memperbarui UI
            $this->dispatch('cartUpdated');
        }
    }

    protected function calculateTotal()
    {
        $this->total = collect($this->cart)->sum(function ($item) {
            return $item['harga'] * $item['quantity'];
        });
    }

    

    public function render()
    {
        return view('livewire.pages.home')
            ->layout('layouts.app')
            ->with([
                'products' => $this->products,
                'cart' => $this->cart,
                'total' => $this->total,
                'search' => $this->search,
            ]);
    }
}