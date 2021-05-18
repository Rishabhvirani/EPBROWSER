<?php

namespace App\Http\Livewire\Forms\User;
use Monarobase\CountryList\CountryListFacade;
use App\Models\UsersModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Livewire\Component;

class Edit extends Component
{
    public $user_id;
    public $countries;
    public $state=[];
    protected $listeners = ['openEdit' => 'openform'];
    
    public function openform($u_id){
        $this->user_id=$u_id;
        $this->state = UsersModel::select('username','email','mobile','email_verified','mobile_verified','user_banned','country')->where(array('u_id'=>$u_id))->first()->toArray();
        $this->state['email_verified'] = $this->state['email_verified'] == 1 ? true:false;
        $this->state['mobile_verified'] = $this->state['mobile_verified'] == 1 ? true:false;
        $this->state['user_banned'] = $this->state['user_banned'] == 1 ? true:false;
    }

    public function mount(){
        $this->countries = CountryListFacade::getlist('en');
        $this->state['country'] = 'US';
    }

    public function update(){
        $this->state['email_verified'] = $this->state['email_verified'] ==  true ? '1' :  '0';
        $this->state['mobile_verified'] = $this->state['mobile_verified'] == true ? '1' : '0';
        $this->state['user_banned'] = $this->state['user_banned'] == true ? '1' : '0';
        $rules = [
            'username' => "required|alpha_dash|unique:tbl_users,username,$this->user_id,u_id",
            'email' => "required|email|unique:tbl_users,email,$this->user_id,u_id",
            'mobile' => "required|integer|unique:tbl_users,mobile,$this->user_id,u_id",
            'mobile_verified'=>'required',
            'country'=>'required',
        ];
        $this->state['ref_code'] = strtolower($this->state['username']);
        $validator = Validator::make($this->state, $rules);
        if ($validator->passes()) {
            // dd($this->state);
            if(UsersModel::where(array('u_id'=>$this->user_id))->update($this->state)){
                $this->reset(['user_id','state']);
                $this->dispatchBrowserEvent('closeform');
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'User Created']);
            }else{
                $this->dispatchBrowserEvent(
                    'alert', ['type' => 'danger',  'message' => 'Something Went wrong']);
            }
                
        }else{
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'danger',  'message' => $validator->errors()->first()]);
        }
    }
    
    
    public function render()
    {
        return view('livewire.forms.user.edit');
    }
}
