<?php

namespace App\Http\Livewire\Module\Settings;
use App\Models\SettingsModel;
use App\Models\TimerModel;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\BookmarksModel;

class Settings extends Component
{
    
    public $active = 'general';

    public function render()
    {
        return view('livewire.module.settings.settings');
    }

    public function get_bookmarks(){
        $data = BookmarksModel::get();
        return response()->json(['success'=>true, 'data' => $data]); 
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
    
    public function get_timers(){
        $data = TimerModel::where(array('active'=>'1'))->select('t_id','timer','points','active')->get();
        return response()->json(['success'=>true, 'data' => $data]);
    }

}
