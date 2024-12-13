<?php

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

    public $kode;
    public $nama_produk;
    public $harga;
    public $stok = 0;
    public $gambar;
    public $id_kategori;
    public $id_toko;
    public $produk_id;
    public $isEdit = false;
    public $search;
    public $new_category_name;

    protected $rules = [
        'kode' => 'required|string|max:50',
        'nama_produk' => 'required|string|max:100',
        'harga' => 'required|numeric|min:0',
        'stok' => 'required|integer|min:0',
        'gambar' => 'nullable|image|max:2048',
        'id_kategori' => 'nullable|exists:kategori,id',
        'id_toko' => 'required|exists:toko,id'
    ];

    public function mount()
    {
        $this->id_toko = auth()->user()->id_toko;
    }

    public function saveProduct()
    {
        $this->validate();

        DB::beginTransaction();
        try {
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

            // Create stock history for initial stock
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
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
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
        $this->validate();

        DB::beginTransaction();
        try {
            $produk = Produk::findOrFail($this->produk_id);
            $oldStok = $produk->stok;

            $data = [
                'kode' => $this->kode,
                'nama_produk' => $this->nama_produk,
                'harga' => $this->harga,
                'stok' => $this->stok,
                'id_kategori' => $this->id_kategori ?: null,
            ];

            if ($this->gambar) {
                if ($produk->gambar) {
                    Storage::disk('public')->delete($produk->gambar);
                }
                $data['gambar'] = $this->gambar->store('produk', 'public');
            }

            $produk->update($data);

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
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
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
        } catch (\Exception $e) {
            DB::rollBack();
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
