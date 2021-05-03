<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationModel extends Model
{
    use HasFactory;
    protected $table = 'tbl_notification';
    protected $primaryKey = 'n_id';
    protected $fillable = [
        'sender',
        'receiver',
        'n_type',
        'points',
        'dollar',
        'coins',   
        'timer',
        'data',
        'ref_type',
        'is_read',
    ];
}
