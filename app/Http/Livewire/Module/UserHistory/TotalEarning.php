<?php

namespace App\Http\Livewire\Module\UserHistory;

use Livewire\Component;

class TotalEarning extends Component
{
    public $user;
    public $totalearning;

    public function mount(){

    }
    
    public function render()
    {
        return view('livewire.module.user-history.total-earning');
    }
}
