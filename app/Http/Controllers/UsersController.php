<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersModel;
class UsersController extends Controller
{
    public function index(){
        return "Asd";
    }   

    public function register()
    {
        $user = UsersModel::create([
            'username'=>'rishabhvirani',
            'email'=>'rishabhvv@gmail.com',
            'password'=>'@@rishabh',
            'mobile'=>'02659562323',
            'coin_address'=>'asdasd',
            'points'=>'25',
            'coins'=>'250',
            'ref_code'=>'acas',
            'verification_code'=>'asdadfasdasd',
            'api_token'=>'asd',
            
        ]);
        return $user;
    }

}
