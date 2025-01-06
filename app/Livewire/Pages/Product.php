<?php
// File: app/Livewire/Pages/Product.php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\RiwayatStok;
use App\Models\Toko;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Product extends Component
{
    use WithFileUploads;

    // Properties
    public $kode;
    public $nama_produk;
    public $harga;
    public $stok ;
    public $gambar;
    public $id_kategori;
    public $id_toko;
    public $produk_id;
    public $isEdit = false;
    public $search;
    public $new_category_name;

    // Validation Rules
    protected $rules = [
        'kode' => 'required|string|max:50',
        'nama_produk' => 'required|string|max:100',
        'harga' => 'required|numeric|min:0',
        'stok' => 'required|integer|min:0',
        'gambar' => 'nullable|image|max:2048',
        'id_kategori' => 'nullable|exists:kategori,id',
        'id_toko' => 'required|exists:toko,id'
    ];

    // Lifecycle Hooks
    public function mount()
    {
        \Log::info('Component mounted');
        $this->id_toko = auth()->user()->id_toko;
    }

    public function updated($propertyName)
    {
        \Log::info('Property updated', ['property' => $propertyName]);
        $this->validateOnly($propertyName);
    }

    // CRUD Operations
    public function saveProduct()
    {
        \Log::info('Attempting to save product', [
            'data' => [ 
                'kode' => $this->kode,
                'nama_produk' => $this->nama_produk,
                'harga' => $this->harga,
                'stok' => $this->stok
            ]
        ]); 

        try {
            $validated = $this->validate();
            \Log::info('Validation passed', $validated);

            DB::beginTransaction();

            $data = [
                'kode' => $this->kode,
                'nama_produk' => $this->nama_produk,
                'harga' => $this->harga,
                'stok' => $this->stok,
                'id_kategori' => $this->id_kategori ?: null,
                'id_toko' => $this->id_toko,
            ];

            if ($this->gambar) {
                $data['gambar'] = $this->gambar->store('produk', 'public');
            }

            $produk = Produk::create($data);
            \Log::info('Product created', ['product_id' => $produk->id]);

            if ($this->stok > 0) {
                RiwayatStok::create([
                    'id_produk' => $produk->id,
                    'perubahan_stok' => $this->stok,
                    'tipe' => 'masuk',
                    'harga_satuan' => $this->harga,
                    'id_pengguna' => auth()->id(),
                    'id_toko' => $this->id_toko,
                ]);
            }

            DB::commit();
            session()->flash('message', 'Produk berhasil ditambahkan.');
            $this->resetForm();
            $this->dispatch('product-saved');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error saving product', ['error' => $e->getMessage()]);
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        \Log::info('Editing product', ['id' => $id]);
        $this->isEdit = true;
        $produk = Produk::findOrFail($id);

        $this->produk_id = $id;
        $this->kode = $produk->kode;
        $this->nama_produk = $produk->nama_produk;
        $this->harga = $produk->harga;
        $this->stok = $produk->stok;
        $this->id_kategori = $produk->id_kategori;
    }

    public function update()
    {
        \Log::info('Attempting to update product', ['id' => $this->produk_id]);

        try {
            $validated = $this->validate();
            \Log::info('Validation passed for update', $validated);

            DB::beginTransaction();

            // Ambil produk yang akan diupdate
            $produk = Produk::findOrFail($this->produk_id);
            $oldStok = $produk->stok;

            // Data yang akan diupdate
            $data = [
                'kode' => $this->kode,
                'nama_produk' => $this->nama_produk,
                'harga' => $this->harga,
                'stok' => $this->stok,
                'id_kategori' => $this->id_kategori ?: null,
            ];

            // Handle upload gambar jika ada
            if ($this->gambar) {
                if ($produk->gambar) {
                    Storage::disk('public')->delete($produk->gambar); // Hapus gambar lama
                }
                $data['gambar'] = $this->gambar->store('produk', 'public'); // Simpan gambar baru
            }

            // Update produk
            $produk->update($data);

            // Catat perubahan stok jika ada
            if ($this->stok != $oldStok) {
                $perubahan = $this->stok - $oldStok;
                RiwayatStok::create([
                    'id_produk' => $produk->id,
                    'perubahan_stok' => abs($perubahan),
                    'tipe' => $perubahan > 0 ? 'masuk' : 'keluar',
                    'harga_satuan' => $this->harga,
                    'id_pengguna' => auth()->id(),
                    'id_toko' => $this->id_toko
                ]);
            }

            DB::commit();
            session()->flash('message', 'Produk berhasil diperbarui.');
            $this->resetForm();
            $this->dispatch('product-updated'); // Dispatch event jika diperlukan

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating product', ['error' => $e->getMessage()]);
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        \Log::info('Attempting to delete product', ['id' => $id]);
        
        try {
            DB::beginTransaction();
            
            $produk = Produk::findOrFail($id);
            if ($produk->stok > 0) {
                RiwayatStok::create([
                    'id_produk' => $produk->id,
                    'perubahan_stok' => $produk->stok,
                    'tipe' => 'keluar',
                    'harga_satuan' => $produk->harga,
                    'id_pengguna' => auth()->id(),
                    'id_toko' => $this->id_toko
                ]);
            }
            
            if ($produk->gambar) {
                Storage::disk('public')->delete($produk->gambar);
            }
            
            $produk->delete();
            DB::commit();
            
            session()->flash('message', 'Produk berhasil dihapus.');
            $this->dispatch('product-deleted');
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error deleting product', ['error' => $e->getMessage()]);
            session()->flash('error', 'Terjadi kesalahan saat menghapus produk: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->reset(['kode', 'nama_produk', 'harga', 'stok', 'gambar', 'id_kategori']);
        $this->isEdit = false;
    }

    public function render()
    {
        \Log::info('Rendering product component');
        
        $query = Produk::with(['kategori'])->where('id_toko', $this->id_toko);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama_produk', 'like', '%' . $this->search . '%')
                  ->orWhere('kode', 'like', '%' . $this->search . '%');
            });
        }

        $products = $query->get();
        $categories = Kategori::where('id_toko', $this->id_toko)->get();

        return view('livewire.pages.product', [
            'products' => $products,
            'categories' => $categories,
        ])->layout('layouts.app');
    }
}