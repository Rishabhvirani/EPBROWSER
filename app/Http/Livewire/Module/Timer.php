<?php

namespace App\Http\Livewire\Module;
use App\Models\TimerModel;
use Livewire\Component;

class Timer extends Component
{
    
    public $enabled_counter;
    public $timers=[];
    public $state=[];

    public function mount(){
        $this->timers =  TimerModel::get()->map(
            function($data) {
                if($data->active == '0'){
                    $data->active = false;
                }else{
                    $data->active = true;
                }
                return $data;
            })->toArray();
        $this->enabled_counter = TimerModel::where(array('active'=>'1'))->get()->count();
    }

    public function render()
    {
        return view('livewire.module.timer');
    }


    public function update($id){
        $tid = $this->timers[$id]['t_id'];
        $data = array(
            'timer'=> $this->timers[$id]['timer'],
            'points'=> $this->timers[$id]['points'],
            'active'=> $this->timers[$id]['active'] == false ? '0' : '1',
        );
        TimerModel::where(array('t_id'=>$tid))->update($data);
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => "Timer $tid Updated Successfully"]);
        $this->mount();
    }
}
