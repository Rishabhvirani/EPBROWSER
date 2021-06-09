<?php

namespace App\Http\Livewire\Module;
use Illuminate\Support\Facades\DB;
use App\Models\WithdrawalModel;
use Livewire\Component;

class Withdrawal extends Component
{

    public $Withdrawal_history;
    
    public function mount(){
        $this->Withdrawal_history = DB::table('tbl_withdrawal_history')
        ->join('tbl_users','tbl_withdrawal_history.user_id','=','tbl_users.u_id','left')
        ->select('tbl_withdrawal_history.*','tbl_users.username','tbl_users.email')
        ->orderByDesc('tbl_withdrawal_history.wh_id')
        ->get();
    }

    // public function get_history_data(){
        
    // }


    public function render()
    {
        return view('livewire.module.withdrawal');
    }

    public function approve($id){
        $this->mount();   
        $this->emit('approve',$id);
    }


    public function decline($id){

        WithdrawalModel::where(array('wh_id'=>$id))->update(array('status'=>'2'));
        $this->mount();
    }

}
