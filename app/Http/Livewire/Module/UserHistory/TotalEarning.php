<?php

namespace App\Http\Livewire\Module\UserHistory;
use Illuminate\Support\Facades\DB;

use Livewire\Component;

class TotalEarning extends Component
{
    public $user;
    public $totalearning;

    public function mount(){
        $this->totalearning = DB::table('tbl_point_history')
        ->join('tbl_users','tbl_point_history.child_id','=','tbl_users.u_id','left')
        ->where(array('tbl_point_history.status'=>'0','tbl_point_history.user_id'=>$this->user))
        ->select('tbl_point_history.*','tbl_users.username as referal_name')
        ->orderByDesc('tbl_point_history.ph_id')
        ->get();
        
    }
    
    public function render()
    {
        return view('livewire.module.user-history.total-earning');
    }
}
