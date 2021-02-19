<?php

namespace App\Http\Livewire\Module;
use App\Models\Users as ModelsUsers;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class Users extends Component
{
    public $username;
    public $email;
    public $password;
    public $password_confirmation;
    public $mobile;
    public $point;
    public $coin;
    public $ref_code;
    public $coin_address;
    public $user = ModelsUsers::class;

    public function render()
    {
        return view('livewire.module.users');
    }

    public function submit(){
        $data = $this->validate([
            'username' => 'required|alpha_dash|unique:tbl_users',
            'email' => 'required|email|unique:tbl_users',
            'password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|confirmed',
            'password_confirmation'=>'required|min:6',
            'mobile' => 'required|integer',
            'point' => 'required|integer',
            'coin' => 'required|integer',
            'ref_code'=>'required|unique:tbl_users',
            'coin_address'=>'required|unique:tbl_users',
        ]);
            $this->user::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'mobile'=>$data['mobile'],
                'coin_address'=>$data['coin_address'],
                'points'=>$data['point'],
                'coins'=>$data['coin'],
                'ref_code'=>$data['ref_code'],
                'ref_id'=>isset($data['ref_id'])?$data['ref_id']:NULL,
                'country'=>isset($data['country'])?$data['country']:NULL,
                'api_token' => Str::random(60),
                'verification_code'=>Str::random(80),
                ]
            );
            return redirect('/');
        
        // if($this->user::create($data))
        // {
        //     return redirect('/');
        // }
        // user::create($data);

        
    }

}
