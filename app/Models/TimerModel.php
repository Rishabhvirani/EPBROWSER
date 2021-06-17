<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimerModel extends Model
{
    use HasFactory;
    protected $table = 'tbl_timer';
    protected $primaryKey = 't_id';
    public $timestamps = true;

    protected $fillable = [
        'timer',
        'points',
        'active',
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
