<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;


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
        'email_verified',
        'device_id',
        'mobile_verified',
    ];

    public function Prepare_User($user){
        
        $data = array(
            'username'=>strtolower($user['username']),
            'email'=>$user['email'],
            'password'=> Hash::make($user['password']),
            'mobile'=>$user['mobile'],
            'mobile_verified'=>isset($user['mobile_verified']) ? $user['mobile_verified'] : '0',
            'country'=>isset($user['country']) ? $user['country'] : '',
            'device_id'=>isset($user['device_id'])  ? $user['device_id'] : '',
            'lat'=>isset($user['lat']) ? $user['lat'] : 0,
            'long'=>isset($user['long']) ? $user['long']:0,
            'api_token'=>Str::random(60),
            'reset_token'=>Str::random(60),
            'verification_code'=>Str::random(80),
            'points'=>isset($user['points']) ? $user['points'] : 0, 
            'ref_code'=>strtolower($user['username']),
            'ref_id'=> isset($user['ref_id']) ? $user['ref_id'] : null,
        );
        return $data;
    }

}
