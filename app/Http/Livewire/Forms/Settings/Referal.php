<?php

namespace App\Http\Livewire\Forms\Settings;
use App\Models\SettingsModel;
use Livewire\Component;

class Referal extends Component
{
    public $isReferalActive = false;
    public $parentEarning = 0;
    public $childEarning = 0;
    public $earningType = 'bonus';
    public $label = 'referal';
    public $setting;

    public function mount(){
        $this->setting =  new SettingsModel;
        $ref_setting = $this->setting->get_settings($this->label);
        $this->isReferalActive = $ref_setting->isReferalActive == '0' ? false:true;
        $this->parentEarning = $ref_setting->parentEarning;
        $this->childEarning = $ref_setting->childEarning;
        $this->earningType = $ref_setting->earningType;
    }



    public function render()
    {
        return view('livewire.forms.settings.referal');
    }

    public function update(){   
        $data = $this->validate([
            'isReferalActive' => 'required',
            'parentEarning' => 'required',
            'childEarning' => 'required',
        ]);
        SettingsModel::where(array('name'=>'isReferalActive','label'=>$this->label))->update(array('value'=>$this->isReferalActive));
        SettingsModel::where(array('name'=>'parentEarning','label'=>$this->label))->update(array('value'=>$this->parentEarning));
        SettingsModel::where(array('name'=>'childEarning','label'=>$this->label))->update(array('value'=>$this->childEarning));
        $this->mount();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Referal Setting updated']);
    }
}
