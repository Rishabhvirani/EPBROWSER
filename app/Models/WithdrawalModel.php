<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalModel extends Model
{
    use HasFactory;
    protected $table = 'tbl_withdrawal_history';
    protected $primaryKey = 'wh_id';
    protected $fillable = [
        'user_id',
        'usd',
        'epc',
        'epc_address',
        'transaction_id',
        'url',
        'status',
    ];

    protected $dates = [
        'created_at', 
        'updated_at', 
    ];


    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

}
