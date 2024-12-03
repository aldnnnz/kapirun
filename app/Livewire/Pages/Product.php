<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Toko;
use App\Models\RiwayatStok;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Product extends Component
{
    use WithFileUploads;

    public $kode;
    public $nama_produk;
    public $harga;
    public $stok = 0;
    public $gambar;
    public $id_kategori;
    public $id_toko;
    public $produk_id;
    public $isEdit = false;

    protected $rules = [
        'kode' => 'required|string|max:50',
        'nama_produk' => 'required|string|max:100',
        'harga' => 'required|numeric',
        'stok' => 'required|integer|min:0',
        'gambar' => 'nullable|image|max:2048',
        'id_kategori' => 'nullable|exists:kategori,id',
        'id_toko' => 'required|exists:toko,id'
    ];

    public function store()
    {
        $this->validate();
        
        DB::beginTransaction();
        try {
            $data = [
                'kode' => $this->kode,
                'nama_produk' => $this->nama_produk,
                'harga' => $this->harga,
                'stok' => $this->stok,
                'id_kategori' => $this->id_kategori,
                'id_toko' => $this->id_toko,
            ];

            if ($this->gambar) {
                $data['gambar'] = $this->gambar->store('produk', 'public');
            }

            $produk = Produk::create($data);

            if ($this->stok > 0) {
                RiwayatStok::create([
                    'id_produk' => $produk->id,
                    'perubahan_stok' => $this->stok,
                    'tipe' => 'masuk',
                    'harga_satuan' => $this->harga,
                    'id_pengguna' => auth()->id(),
                    'id_toko' => $this->id_toko
                ]);
            }

            DB::commit();
            $this->reset();
            session()->flash('message', 'Produk berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $this->isEdit = true;
        $this->produk_id = $id;
        $produk = Produk::findOrFail($id);
        
        $this->kode = $produk->kode;
        $this->nama_produk = $produk->nama_produk;
        $this->harga = $produk->harga;
        $this->stok = $produk->stok;
        $this->id_kategori = $produk->id_kategori;
        $this->id_toko = $produk->id_toko;
    }

    public function update()
    {
        $this->validate();
        
        $produk = Produk::findOrFail($this->produk_id);
        $data = [
            'kode' => $this->kode,
            'nama_produk' => $this->nama_produk,
            'harga' => $this->harga,
            'stok' => $this->stok,
            'id_kategori' => $this->id_kategori,
            'id_toko' => $this->id_toko,
        ];

        if ($this->gambar) {
            $data['gambar'] = $this->gambar->store('produk', 'public');
        }

        $produk->update($data);
        $this->reset();
        $this->isEdit = false;
        session()->flash('message', 'Produk berhasil diperbarui.');
    }

    public function delete($id)
    {
        Produk::findOrFail($id)->delete();
        session()->flash('message', 'Produk berhasil dihapus.');
    }

    public function render()
    {
        $products = Produk::with(['kategori', 'toko'])->get();
        $categories = Kategori::all();
        $stores = Toko::all();
        
        return view('livewire.pages.product', [
            'products' => $products,
            'categories' => $categories,
            'stores' => $stores
        ])->layout('layouts.app');
    }
}
