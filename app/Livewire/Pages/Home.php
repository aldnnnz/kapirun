<?php
namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\RiwayatStok;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Home extends Component
{
    public $products = [];
    public $cart = [];
    public $total = 0;
    public $search = '';
    public $inputBayar = 0;
    public $kembalian = 0; // Properti untuk menyimpan nilai kembalian

    public function mount()
    {
        // Ambil data produk dengan kolom yang sesuai
        $this->products = Produk::where('id_toko', Auth::user()->id_toko)->get();     
        
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
    
        // Hitung ulang kembalian setelah total diupdate
        $this->kembalian = max(0, $this->inputBayar - $this->total);
    }
    
    public function updatedInputBayar($value)
    {
        // Hitung kembalian setiap kali inputBayar diubah
        $this->kembalian = max(0, $this->inputBayar - $this->total);
    }
    
    public function updatedTotal($value)
    {
        // Hitung kembalian setiap kali total diubah
        $this->kembalian = max(0, $this->inputBayar - $this->total);
    }

    public function checkout()
    {
        // Validasi input bayar
        if ($this->inputBayar < $this->total) {
            session()->flash('error', 'Uang pembayaran kurang!');
            return;
        }

        // Validasi stok produk
        foreach ($this->cart as $item) {
            $product = Produk::find($item['id']);
            if ($product->stok < $item['quantity']) {
                session()->flash('error', 'Stok produk ' . $product->nama_produk . ' tidak mencukupi!');
                return;
            }
        }

        // Mulai transaksi database
        DB::beginTransaction();
        try {
            // Generate nomor nota (contoh: TRX-001)
            $lastTransaksi = Transaksi::where('id_toko', Auth::user()->id_toko)
                ->orderBy('id', 'desc')
                ->first();
            $nomorNota = 'TRX-' . str_pad($lastTransaksi ? $lastTransaksi->id + 1 : 1, 3, '0', STR_PAD_LEFT);

            // Simpan transaksi
            $transaksi = Transaksi::create([
                'nomor_nota' => $nomorNota,
                'id_kasir' => Auth::id(),
                'id_pelanggan' => null, // Jika ada pelanggan, bisa disesuaikan
                'id_toko' => Auth::user()->id_toko,
                'total' => $this->total,
                'jumlah_bayar' => $this->inputBayar,
                'kembalian' => $this->kembalian,
            ]);

            // Simpan detail transaksi dan kurangi stok
            foreach ($this->cart as $item) {
                // Simpan detail transaksi
                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id,
                    'id_produk' => $item['id'],
                    'jumlah' => $item['quantity'],
                    'harga_satuan' => $item['harga'],
                ]);

                // Kurangi stok produk
                $product = Produk::find($item['id']);
                $product->stok -= $item['quantity'];
                $product->save();

                // Catat riwayat stok
                RiwayatStok::create([
                    'id_produk' => $item['id'],
                    'perubahan_stok' => $item['quantity'],
                    'tipe' => 'keluar',
                    'harga_satuan' => $item['harga'],
                    'id_pengguna' => Auth::id(),
                    'id_toko' => Auth::user()->id_toko,
                ]);
            }

            // Commit transaksi
            DB::commit();

            // Reset keranjang dan total
            session()->forget('cart');
            $this->cart = [];
            $this->total = 0;
            $this->inputBayar = 0;
            $this->kembalian = 0;

            // Beri pesan sukses
            session()->flash('message', 'Transaksi berhasil!');
        } catch (\Exception $e) {
            // Rollback transaksi jika ada error
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
                'inputBayar' => $this->inputBayar,
                'kembalian' => $this->kembalian,
            ]);
    }

    public function processCheckout()
{
    // Validasi nilai pembayaran dan kembalian
    if ($this->inputBayar > 9999999999999.99 || $this->kembalian > 9999999999999.99) {
        session()->flash('error', 'Nilai pembayaran atau kembalian terlalu besar!');
        return;
    }

    // Validasi input bayar
    if ($this->inputBayar < $this->total) {
        session()->flash('error', 'Uang pembayaran kurang!');
        return;
    }

    // Validasi stok produk
    foreach ($this->cart as $item) {
        $product = Produk::find($item['id']);
        if ($product->stok < $item['quantity']) {
            session()->flash('error', 'Stok produk ' . $product->nama_produk . ' tidak mencukupi!');
            return;
        }
    }

    // Mulai transaksi database
    DB::beginTransaction();
    try {
        // Generate nomor nota (contoh: TRX-001)
        $lastTransaksi = Transaksi::where('id_toko', Auth::user()->id_toko)
            ->orderBy('id', 'desc')
            ->first();
        $nomorNota = 'TRX-' . str_pad($lastTransaksi ? $lastTransaksi->id + 1 : 1, 3, '0', STR_PAD_LEFT);

        // Simpan transaksi
        $transaksi = Transaksi::create([
            'nomor_nota' => $nomorNota,
            'id_kasir' => Auth::id(),
            'id_pelanggan' => null, // Jika ada pelanggan, bisa disesuaikan
            'id_toko' => Auth::user()->id_toko,
            'total' => $this->total,
            'jumlah_bayar' => $this->inputBayar,
            'kembalian' => $this->kembalian,
        ]);

        // Simpan detail transaksi dan kurangi stok
        foreach ($this->cart as $item) {
            // Simpan detail transaksi
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id,
                'id_produk' => $item['id'],
                'jumlah' => $item['quantity'],
                'harga_satuan' => $item['harga'],
            ]);

            // Kurangi stok produk
            $product = Produk::find($item['id']);
            $product->stok -= $item['quantity'];
            $product->save();

            // Catat riwayat stok
            RiwayatStok::create([
                'id_produk' => $item['id'],
                'perubahan_stok' => -$item['quantity'],
                'tipe' => 'keluar',
                'harga_satuan' => $item['harga'],
                'id_pengguna' => Auth::id(),
                'id_toko' => Auth::user()->id_toko,
            ]);
        }

        // Commit transaksi
        DB::commit();

        // Reset keranjang dan total
        session()->forget('cart');
        $this->cart = [];
        $this->total = 0;
        $this->inputBayar = 0;
        $this->kembalian = 0;

        // Beri pesan sukses
        session()->flash('message', 'Transaksi berhasil!');
    } catch (\Exception $e) {
        // Rollback transaksi jika ada error
        DB::rollBack();
        session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}
}