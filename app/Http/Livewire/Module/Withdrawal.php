<?php

namespace App\Http\Livewire\Module;
use Illuminate\Support\Facades\DB;
use App\Models\WithdrawalModel;
use App\Models\NotificationModel;
use App\Models\UsersModel;
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


    public function render()
    {
        return view('livewire.module.withdrawal');
    }

    public function approve($id){
        $this->mount();   
        $this->emit('approve',$id);
    }


    public function decline($id){
        $wh = DB::table('tbl_withdrawal_history')
        ->join('tbl_users','tbl_withdrawal_history.user_id','=','tbl_users.u_id','left')
        ->where(array('tbl_withdrawal_history.wh_id'=>$id))
        ->select('tbl_withdrawal_history.*','tbl_users.username','tbl_users.email')
        ->first();
        WithdrawalModel::where(array('wh_id'=>$id))->update(array('status'=>'2'));
        $update_data = array(
            'usd'=>DB::raw('`usd`+'.$wh->usd),
        );
        UsersModel::where(array('u_id'=>$wh->user_id))->update($update_data);
        NotificationModel::create(
            array(
                'receiver'=> $wh->user_id,
                'n_type'=>'w',
                'usd'=>$wh->usd,
                'coins'=>$wh->epc,
                'w_status'=>'d'
            )
        );
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Withdrawal Request Declined Successfully']);
        $this->mount();
    }

}
