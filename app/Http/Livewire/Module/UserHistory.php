<?php

namespace App\Http\Livewire\Module;
use App\Models\UsersModel;
use App\Models\PointHistoryModel;
use App\Models\WithdrawalModel;
use Livewire\Component;

class UserHistory extends Component
{
    public $user_id;
    public $total_referal_user;
    public $total_earning;
    public $total_withdrawal;
    public $total_referal_earning;
    public $tab = 'child_users';
    
    public function mount($id)
    {
        $this->user_id = $id;   
        $this->total_referal_user = UsersModel::where(array('status'=>'0','ref_id'=>$this->user_id))->count();
        $this->total_earning = PointHistoryModel::where(array('status'=>'0','user_id'=>$this->user_id))->sum('point');
        $this->total_withdrawal = WithdrawalModel::where(array('status'=>'1','user_id'=>$this->user_id))->sum('usd');
        $this->total_referal_earning = PointHistoryModel::where(array('status'=>'0','user_id'=>$this->user_id,'earn_type'=>'r','ref_type'=>'p'))->sum('point');
    }

    public function render()
    {
        return view('livewire.module.user-history');
    }

}
