<?php

namespace App\Http\Livewire\Module\UserHistory;
use App\Models\UsersModel;
use Livewire\Component;

class ChildUsers extends Component
{

    public $user;
    public $users;

    public function mount(){
        $this->dispatchBrowserEvent('table');
        $this->users = UsersModel::where(array('status'=>'0','ref_id'=>$this->user))->OrderBy('u_id','DESC')->get();
    }


    public function render()
    {   
        return view('livewire.module.user-history.child-users');
        
    }
    public function openEdit($u_id){
        $this->emit('openEdit',$u_id);
        $this->mount();
    }

}
