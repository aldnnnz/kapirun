<?php
// app/Http/Livewire/Components/Layout.php
namespace App\Http\Livewire\Components;

use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Layout extends Component
{
    // public $currentPage;

    // public function mount($cuarrentPage = 'dashboard')
    // {
    //     $this->currentPage = $currentPage;
    // }

    public function render()
    {
        return view('livewire.components.layout');
    }

    
}