<?php

namespace App\Http\Livewire\Forms\Settings;
use App\Models\SettingsModel;

use Livewire\Component;

class General extends Component
{
    public $isNotificationEnabled = false;
    public $isWithdrwalEnabled = false;
    public $label = 'general';
    public $setting;


    public function mount(){
        $this->setting =  new SettingsModel;
        $data['label'] = $this->label;
        $gen_setting = $this->setting->get_settings($data);
        $this->isNotificationEnabled = $gen_setting->isNotificationEnabled == '0' ? false:true;
        $this->isWithdrwalEnabled = $gen_setting->isWithdrwalEnabled == '0' ? false:true;
    }

    public function render()
    {
        return view('livewire.forms.settings.general');
    }

    public function update(){
        $data = $this->validate([
            'isNotificationEnabled' => 'required',
            'isWithdrwalEnabled' => 'required',
        ]);
        SettingsModel::where(array('name'=>'isNotificationEnabled','label'=>$this->label))->update(array('value'=>$this->isNotificationEnabled));
        SettingsModel::where(array('name'=>'isWithdrwalEnabled','label'=>$this->label))->update(array('value'=>$this->isWithdrwalEnabled));
        $this->mount();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Notification Setting updated']);
    }

}
