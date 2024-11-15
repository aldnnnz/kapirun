<?php
// app/Livewire/Pages/Home.php
namespace App\Livewire\Pages;
use Livewire\Component;

class Home extends Component
{
    
    public function render()
    {
        return view('livewire.pages.home')
        ->layout('layouts.app')
        ->section('content')
        ;
    }
}
