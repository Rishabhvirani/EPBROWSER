<?php
namespace App\Http\Livewire\Module;
use App\Models\UsersModel;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;




class Users extends Component
{
    public $username;
    public $email;
    public $password;
    public $password_confirmation;
    public $mobile;
    public $point;
    public $coin;
    public $ref_code;
    public $coin_address;
    
    public $rules = [
        'username' => 'required|alpha_dash|unique:tbl_users',
        'email' => 'required|email|unique:tbl_users',
        'password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
        'mobile' => 'required|integer|unique:tbl_users',
        'point' => 'required|integer',
        'coin' => 'required|integer',
        'ref_code'=>'required|unique:tbl_users',
        'coin_address'=>'required|unique:tbl_users',
    ];

    



    public function render()
    {
        return view('livewire.module.users');
    }

    public function register(Request $request){
        $userModel =  new UsersModel;
        $response = array('response' => '', 'success'=>false);
        
        if( $request->is('api/*')){
            $data = $request->json()->all();
            $validator = Validator::make($data, $this->rules);
            if ($validator->passes()) {
                $userModel->username = strtolower($data['username']);
                $userModel->email = $data['email'];
                $userModel->password = Hash::make($data['password']);
                $userModel->mobile = $data['mobile'];
                $userModel->coin_address = $data['coin_address'];
                $userModel->points = $data['point'];
                $userModel->coins = $data['coin'];
                $userModel->ref_code = $data['ref_code'];
                $userModel->ref_id = isset($data['ref_id'])?$data['ref_id']:NULL;
                $userModel->country = isset($data['country'])?$data['country']:NULL;
                $userModel->api_token = Str::random(60);
                $userModel->verification_code = Str::random(80);

                if($userModel->save()){
                    $response['success']=true;
                    $response['response']=array(
                        'message'=>'User Created Successfully',
                        'data'=> array(
                            'id'=>$userModel->u_id,
                            'username'=>$userModel->username,
                            'email'=>$userModel->email,
                            'mobile'=>$userModel->mobile,
                            'points'=>$userModel->points,
                            'coins'=>$userModel->coins,
                            'ref_code'=>$userModel->ref_code,
                            'country'=>$userModel->country,
                            'coin_address'=>$userModel->coin_address,
                            'api_token'=>$userModel->api_token,
                        )
                    );
                    return response($response);
                }else{
                    return response($response);
                }
            } else {
                $response['response'] = $validator->errors()->messages();
                return response()->json($response);
            }
        }else{
            $data = $this->validate([
                'username' => 'required|alpha_dash|unique:tbl_users',
                'email' => 'required|email|unique:tbl_users',
                'password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|confirmed',
                'password_confirmation'=>'required|min:6',
                'mobile' => 'required|integer',
                'point' => 'required|integer',
                'coin' => 'required|integer',
                'ref_code'=>'required|unique:tbl_users',
                'coin_address'=>'required|unique:tbl_users',
            ]);
            $this->user::create([
                'username' => strtolower($data['username']),
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'mobile'=>$data['mobile'],
                'coin_address'=>$data['coin_address'],
                'points'=>$data['point'],
                'coins'=>$data['coin'],
                'ref_code'=>$data['ref_code'],
                'ref_id'=>isset($data['ref_id'])?$data['ref_id']:NULL,
                'country'=>isset($data['country'])?$data['country']:NULL,
                'api_token'=>Str::random(60),
                'verification_code'=>Str::random(80),
                ]
            );
            return redirect('/');
        }
        
    }

    public function login(Request $request){
        if( $request->is('api/*')){
            
            $username = $request->input('username');
            $password = $request->input('password');
            $user = UsersModel::where('username', '=', $username)->first();
            if (!$user) {
               return response()->json(['success'=>false, 'message' => 'Login Fail, please check username']);
            }
            if (!Hash::check($password, $user->password)) {
               return response()->json(['success'=>false, 'message' => 'Login Fail, pls check password']);
            }
            return response()->json(['success'=>true,'message'=>'success', 'data' => array(
                'id'=>$user->u_id,
                'username'=>$user->username,
                'email'=>$user->email,
                'mobile'=>$user->mobile,
                'points'=>$user->points,
                'coins'=>$user->coins,
                'ref_code'=>$user->ref_code,
                'country'=>$user->country,
                'coin_address'=>$user->coin_address,
                'api_token'=>$user->api_token,
            )]);   
        }
    }

    public function hello(){
        return "";
    }



}
