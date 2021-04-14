<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class UsersModel extends Model
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
        'reset_token',
        'verification_code',
    ];
 
    // protected $fillable = [
    //     'username',
    //     'email',
    //     'password',
    //     'mobile',
    //     'coin_address',
    //     'points',
    //     'coins',
    //     'ref_id',
    //     'ref_code',
    //     'country',
    //     'api_token',
    //     'verification_code',
    // ];


    public function Prepare_User($user){

        $data = array(
            'username'=>strtolower($user['username']),
            'email'=>$user['email'],
            'password'=> Hash::make($user['password']),
            'mobile'=>$user['mobile'],
            'mobile_verified'=>$user['mobile_verified'],
            'country'=>$user['country'],
            'device_id'=>$user['device_id'],
            'lat'=>$user['lat'],
            'long'=>$user['long'],
            'api_token'=>Str::random(60),
            'reset_token'=>Str::random(60),
            'verification_code'=>Str::random(80),
            'ref_code'=>strtolower($user['username']),
        );
        return $data;
    }


}
