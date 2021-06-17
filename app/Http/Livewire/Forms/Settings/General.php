<?php

namespace App\Http\Livewire\Forms\Settings;
use App\Models\SettingsModel;

use Livewire\Component;

class General extends Component
{
    public $isNotificationEnabled = false;
    public $appVersion = '';
    public $label = 'general';
    public $TimerParentEarning;
    public $isTimerActive = false;
    public $setting;
    

    public function mount(){
        $this->setting =  new SettingsModel;
        $data['label'] = $this->label;
        $gen_setting = $this->setting->get_settings($data);
        $this->isNotificationEnabled = $gen_setting->isNotificationEnabled == '0' ? false:true;
        $this->appVersion = $gen_setting->appVersion;
        $this->TimerParentEarning = $gen_setting->TimerParentEarning;
        $this->isTimerActive = $gen_setting->isTimerActive == '0' ? false:true;
    }

    public function render()
    {
        return view('livewire.forms.settings.general');
    }

    public function update(){
        $data = $this->validate([
            'isNotificationEnabled' => 'required',
            'appVersion' => 'required',
            'isTimerActive' => 'required',
            'TimerParentEarning' => 'required',
        ]);
        
        SettingsModel::where(array('name'=>'isNotificationEnabled','label'=>$this->label))->update(array('value'=>$this->isNotificationEnabled));
        SettingsModel::where(array('name'=>'appVersion','label'=>$this->label))->update(array('value'=>$this->appVersion));
        SettingsModel::where(array('name'=>'TimerParentEarning','label'=>$this->label))->update(array('value'=>$this->TimerParentEarning));
        SettingsModel::where(array('name'=>'isTimerActive','label'=>$this->label))->update(array('value'=>$this->isTimerActive));
        
        $this->mount();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'General Setting updated']);
    }

}
