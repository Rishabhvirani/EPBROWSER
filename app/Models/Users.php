<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Users extends Model
{
    use HasFactory;
    protected $table = 'tbl_users';
    protected $primaryKey = 'u_id';
    protected $fillable = [
        'username',
        'email',
        'password',
        'mobile',
        'coin_address',
        'points',
        'coins',
        'ref_id',
        'ref_code',
        'country',
        'api_token',
        'verification_code',
    ];


    

}
