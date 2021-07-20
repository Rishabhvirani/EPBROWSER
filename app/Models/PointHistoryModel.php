<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PointHistoryModel extends Model
{
    use HasFactory;
    protected $table = 'tbl_point_history';
    protected $primaryKey = 'ph_id';
    
    protected $fillable = [
        'user_id',
        'point',
        'earn_type',
        'ref_type',
        'timer_id',
        'child_id'
    ];

    protected $dates = [
        'created_at', 
        'updated_at', 
    ];

    // protected $dateFormat = 'U';
 

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

}
