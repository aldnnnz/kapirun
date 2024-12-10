<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Avatar extends Component
{
    public $user;
    

    public function mount()
    {
        $this->user = Auth::user();
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login');
    }

    public function render()
    {
        return view('livewire.components.avatar', [
            'user' => $this->user
        ]);
    }
}
