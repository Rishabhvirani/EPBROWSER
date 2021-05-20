<?php

namespace App\Http\Livewire\Forms\User;
use App\Models\UsersModel;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Rules\Referal;
use App\Models\SettingsModel;
use Monarobase\CountryList\CountryListFacade;

class Create extends Component
{
    public $state = [];
    public $showform = false;
    public $countries;
    public $selectedcountry;

    public function openform(){
        $this->showform = true;
        $this->dispatchBrowserEvent('openform');
    }

    public function mount(){
        $this->countries = CountryListFacade::getlist('en');
        $this->state['country'] = 'US';
    }

    public function hydrate(){
        $this->countries = CountryListFacade::getlist('en');
    }

    public function render()
    {
        return view('livewire.forms.user.create');
    }

    public function register(){
        
        $userModel = new UsersModel();
        $settings =  new SettingsModel;
        $refdata['label'] = 'referal';
        $ref_setting = $settings->get_settings($refdata);
        $rules = [
            'username' => 'required|alpha_dash|unique:tbl_users',
            'email' => 'required|email|unique:tbl_users',
            'password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@#%]).*$/|confirmed',
            'password_confirmation'=>'required|min:6',
            'mobile' => 'required|integer|unique:tbl_users|min:9',
            'ref_code'=> new Referal($this->state),
            'country'=>'required'
        ];
        $validator = Validator::make($this->state,$rules);
        if ($validator->passes()) {
            if($ref_setting->isReferalActive == 1){
                $ref_user =  UsersModel::where('ref_code','=',strtolower($this->state['ref_code']))->where('status','0')->first();
                if(isset($ref_user->u_id)){
                    $this->state['ref_id'] = $ref_user->u_id;    
                    $this->state['points'] = $ref_setting->childEarning;   
                    UsersModel::where(array('u_id'=>$this->state['ref_id']))->update(['points' => DB::raw('points + '.$ref_setting->parentEarning)]);
                }
            }
            $user = $userModel->Prepare_User($this->state);
            if(UsersModel::create($user)){
                $this->reset('state');
                $this->emit('userCreated');
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
}
