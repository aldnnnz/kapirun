<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;

class ModalCategory extends Component
{
    public $id_kategori;
    public $new_category_name;

    public function addNew()
    {
        $this->id_kategori = 'add_new';
    }

    public function saveCategory()
    {
        $this->validate([
            'new_category_name' => 'required|string|max:50'
        ]);

        $kategori = new Kategori();
        $kategori->nama_kategori = $this->new_category_name;
        $kategori->id_toko = Auth::user()->id_toko;
        $kategori->save();

        $this->reset(['id_kategori', 'new_category_name']);
        $this->dispatch('categoryAdded');
    }

    public function cancelAddCategory()
    {
        $this->reset(['id_kategori', 'new_category_name']);
    }

    public function render()
    {
        return view('livewire.components.modal-category');
    }
}
