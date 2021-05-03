<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


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
    ];
    
}
