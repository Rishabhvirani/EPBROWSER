<?php

namespace App\Http\Livewire\Forms\Settings;
use App\Models\SettingsModel;
use Livewire\Component;

class Conversion extends Component
{
    public $isConversionEnabled = false;
    public $ConversionRate  = 0;
    public $label = 'conversion';
    public $points;
    public $dollar;
    public $setting;

    public function mount(){
        $this->setting =  new SettingsModel;
        $data['label'] = $this->label;
        $conv_setting = $this->setting->get_settings($data);
        $this->isConversionEnabled = $conv_setting->isConversionEnabled == '0' ? false:true;
        $this->ConversionRate = $conv_setting->ConversionRate;
        if($this->ConversionRate == NULL || $this->ConversionRate == 0){
            $this->points = 0;
            $this->dollar = 0;
        }else{
            $ConversionRate = explode(":",$this->ConversionRate);
            
            $this->points = $ConversionRate[0];
            $this->dollar = $ConversionRate[1];
        }
    }

    public function update(){
        $data = $this->validate([
            'points' => 'required|min:1|numeric',
            'dollar' => 'required|min:1|numeric',
            'isConversionEnabled' => 'required',
        ]);
        
        $this->ConversionRate = $this->points . ':'. $this->dollar; 
        
        SettingsModel::where(array('name'=>'isConversionEnabled','label'=>$this->label))->update(array('value'=>$this->isConversionEnabled));
        SettingsModel::where(array('name'=>'ConversionRate','label'=>$this->label))->update(array('value'=>$this->ConversionRate));
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Conversion Setting updated']);


    }


    public function render()
    {
        return view('livewire.forms.settings.conversion');
    }

}
