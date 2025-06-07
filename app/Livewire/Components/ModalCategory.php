<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;

class ModalCategory extends Component
{
    public $id_kategori;
    public $new_category_name;
    public $id_toko;

    protected $listeners = ['refreshCategories' => '$refresh'];
    public function mount()
    {
        $this->id_toko = Auth::user()->id_toko;
        $this->id_kategori = null;
        $this->new_category_name = '';
    }
    public function updatedIdKategori($value)
    {
        if ($value === 'add_new') {
            $this->new_category_name = '';
        } else {
            $kategori = Kategori::find($value);
            if ($kategori) {
                $this->new_category_name = $kategori->nama_kategori;
            }
        }
    }
    public function updatedNewCategoryName($value)
    {
        if ($this->id_kategori !== 'add_new') {
            $this->id_kategori = null;
        }
    }
    public function selectCategory($id)
    {
        $this->id_kategori = $id;
        $kategori = Kategori::find($id);
        if ($kategori) {
            $this->new_category_name = $kategori->nama_kategori;
        }
    }
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
        $kategori->id_toko = $this->id_toko;
        $kategori->save();

        $this->reset(['id_kategori', 'new_category_name']);
        $this->dispatch('categoryAdded');
        session()->flash('message', 'Category added successfully!');
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
