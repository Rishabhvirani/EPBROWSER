<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimerHistoryModel extends Model
{
    use HasFactory;
    protected $table = 'tbl_timer_history';
    protected $primaryKey = 'th_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'timer_id',
        'points',
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
