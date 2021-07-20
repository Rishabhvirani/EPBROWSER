<?php

namespace App\Http\Livewire\Module\UserHistory;
use App\Models\UsersModel;
use Livewire\Component;

class ChildUsers extends Component
{

    public $user;
    public $users;

    public function mount(){
        $this->users = UsersModel::where(array('status'=>'0','ref_id'=>$this->user))->OrderBy('u_id','DESC')->get();
        $this->dispatchBrowserEvent('table');
    }


    public function render()
    {   
        return view('livewire.module.user-history.child-users');
        
    }
}
