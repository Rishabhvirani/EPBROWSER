<?php

namespace App\Http\Livewire\Forms\Withdrawal;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\WithdrawalModel;
use App\Models\NotificationModel;
use Livewire\Component;

class Approve extends Component
{

    public $wh_id;
    
    public $state=[];
    protected $listeners = ['approve' => 'popform'];

    public function popform($id){
        $this->wh_id= $id;
        $wh = DB::table('tbl_withdrawal_history')
        ->join('tbl_users','tbl_withdrawal_history.user_id','=','tbl_users.u_id','left')
        ->where(array('tbl_withdrawal_history.wh_id'=>$this->wh_id))
        ->select('tbl_withdrawal_history.*','tbl_users.username','tbl_users.email')
        ->first();
        // dd($this->wh);
        
        $this->state['username'] = $wh->username;
        $this->state['email'] = $wh->email;
        $this->state['usd'] = $wh->usd;
        $this->state['epc'] = $wh->epc;
        $this->state['epc_address'] = $wh->epc_address;
        $this->state['transaction_id'] = $wh->transaction_id;
        $this->state['url'] = $wh->url;        
    }

    public function render()
    {
        return view('livewire.forms.withdrawal.approve');
    }


    public function update(){

        
        $data['transaction_id'] = $this->state['transaction_id'];
        $data['url'] = $this->state['url'];
        $data['status']='1';
        $rules = array(
            'transaction_id'=>'required',
            'url'=>'required|url'
        );

        $validator = Validator::make($data, $rules);
        if ($validator->passes()){    
            WithdrawalModel::where(array('wh_id'=>$this->wh_id))->update($data);  
            // NotificationModel::create(
            //     array(
            //         'receiver'=> '',
            //         'n_type'=>'w',
            //         'usd'=>'',
            //         'coins'=>'',
            //         'w_status'=>''
            //     )
            // )
            
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'success',  'message' => 'Withdraw request successfully approved and updated']);
        }else{
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'danger',  'message' => $validator->errors()->first()]);
        }
    }


}
