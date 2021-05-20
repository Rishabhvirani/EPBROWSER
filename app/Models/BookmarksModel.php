<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookmarksModel extends Model
{
    use HasFactory;
    protected $table = 'tbl_bookmarks';
    protected $primaryKey = 'id';
    protected $fillable = [
        'label',
        'img_path',
        'link',
        'order',
        
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
