<?php

namespace App\Http\Livewire\Layouts;

use Livewire\Component;

class Sidebar extends Component
{   
    // Public $page='dashboard';

    public function render()
    {
        return view('livewire.layouts.sidebar');
    }
    
    // public function page($page){
    //     return view('livewire.Pages.'.$page);

    //      return view('livewire.show-posts')
    //         ->layout('layouts.base');
    // }


}
