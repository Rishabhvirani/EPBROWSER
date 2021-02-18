<?php

namespace App\Http\Livewire\Layouts;

use Livewire\Component;

class Sidebar extends Component
{
    public function render()
    {
        return view('livewire.layouts.sidebar');
    }
    
    public function navigate($page='dashboard'){
        return view("livewire.module.$page");
    }


}
