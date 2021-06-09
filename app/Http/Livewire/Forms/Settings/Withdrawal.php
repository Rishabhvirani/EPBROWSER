<?php

namespace App\Http\Livewire\Forms\Settings;
use App\Models\SettingsModel;
use Livewire\Component;

class Withdrawal extends Component
{

    public $isWithdrwalEnabled = false;
    public $epc_rate = '';
    public $MinWithdrawal  = '';
    public $label = 'Withdrawal';
    public $setting;


    public function mount(){
        $this->setting =  new SettingsModel;
        $data['label'] = $this->label;
        $withdrawal_setting = $this->setting->get_settings($data);
        $this->isWithdrwalEnabled = $withdrawal_setting->isWithdrwalEnabled == '0' ? false:true;
        $this->MinWithdrawal = $withdrawal_setting->MinWithdrawal;
        $this->epc_rate = $withdrawal_setting->epc_rate;
    }

    public function render()
    {
        return view('livewire.forms.settings.withdrawal');
    }

    public function update(){
        $data = $this->validate([
            'MinWithdrawal' => 'required|numeric|not_in:0',
            'epc_rate' => 'required|numeric|not_in:0',
            'isWithdrwalEnabled' => 'required',
        ]);
        SettingsModel::where(array('name'=>'MinWithdrawal','label'=>$this->label))->update(array('value'=>$this->MinWithdrawal));
        SettingsModel::where(array('name'=>'epc_rate','label'=>$this->label))->update(array('value'=>$this->epc_rate));
        SettingsModel::where(array('name'=>'isWithdrwalEnabled','label'=>$this->label))->update(array('value'=>$this->isWithdrwalEnabled));
        $this->mount();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Withdrawal Setting updated']);
    }


    



}
