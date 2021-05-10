<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversionModel extends Model
{
    use HasFactory;
    protected $table = 'tbl_conversion_history';
    protected $primaryKey = 'id';
    protected $fillable = [
        'u_id',
        'points',
        'usd',
        'conversionRate',
        
    ];

    protected $dates = [
        'created_at', 
        'updated_at', 
    ];

    protected $dateFormat = 'U';
 

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];


}
