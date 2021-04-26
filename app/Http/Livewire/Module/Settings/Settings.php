<?php

namespace App\Http\Livewire\Module\Settings;
use App\Models\SettingsModel;
use Livewire\Component;

class Settings extends Component
{
    

    public function render()
    {
        
        return view('livewire.module.settings.settings');
    }


    public function get_settings(){
        $setting =  new SettingsModel;
        $ref_setting = $setting->get_typewise_settings('p'); 
        $response['response'] = $ref_setting;
        return response()->json($response);
    }

}
