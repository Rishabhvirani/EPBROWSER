<?php

namespace App\Http\Livewire\Module;

use Livewire\Component;

class Users extends Component
{
    public $username;
    public $email;
    public $password;
    public $mobile;
    public $point;
    public $coins;
    public $ref_code;
    public $coin_address;

    public function render()
    {
        return view('livewire.module.users');
    }

    public function submit(){

        $data = $this->validate([
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|password:api',
            'mobile' => 'required|integer',
            'point' => 'required',
            'coins' => 'required',
            'ref_code'=>'required',
            'coin_address'=>'required',
        ]);

    }

}
