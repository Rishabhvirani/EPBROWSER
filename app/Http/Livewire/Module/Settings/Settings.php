<?php

namespace App\Http\Livewire\Module\Settings;
use App\Models\SettingsModel;
use Livewire\Component;
use Illuminate\Http\Request;

class Settings extends Component
{
    

    public function render()
    {
        return view('livewire.module.settings.settings');
    }


    public function get_settings(Request $request){
        $data = $request->json()->all();
        
        if(!isset($data['label'])){
            unset($data['label']);
        }
        if(!isset($data['type'])){
            unset($data['type']);
        }
        $setting =  new SettingsModel;
        $settings = $setting->get_settings($data); 
        $response['response'] = $settings;
        return response()->json($response);
    }
    
}
