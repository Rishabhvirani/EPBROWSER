<?php
namespace App\Http\Livewire\Module;
use App\Models\UsersModel;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use PDO;

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
        'mobile_verified'=>'required',
        'country'=>'required',
        'device_id'=>'required|unique:tbl_users',
        'lat'=>'required',
        'long'=>'required',
        'device_id'=>'required|unique:tbl_users',
    ];

    public function render()
    {
        return view('livewire.module.users');
    }

    public function register(Request $request){
        $userModel =  new UsersModel;
        $response = array('response' => '','success'=>false);
        if( $request->is('api/*')){
            $data = $request->json()->all();
            $validator = Validator::make($data, $this->rules);
            if ($validator->passes()) {
                $user = $userModel->Prepare_User($data);
                $user = UsersModel::create($user);
                if($user){
                    $this->send_email_verification($user->email,$user->verification_code);
                    $response['success']=true;
                    $response['response']=array(
                        'message'=>'User Created Successfully',
                        'data'=> array(
                            'id'=>$user->u_id,
                            'username'=>$user->username,
                            'email'=>$user->email,
                            'mobile'=>$user->mobile,
                            'points'=>$user->points == null ? "0" : $user->points,
                            'coins'=>$user->coins == null ? "0" : $user->coins,
                            'ref_code'=>$user->ref_code,
                            'country'=>$user->country,
                            'coin_address'=>$user->coin_address == null ? "" : $user->coin_address ,
                            'api_token'=>$user->api_token,
                            'email_verified'=>$user->email_verified == null ? "0" : $user->email_verified,
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
            
            $userModel::create([
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
            return redirect('/users');
        }   
    }

    public function login(Request $request){
        if( $request->is('api/*')){
            $username = $request->input('username');
            $password = $request->input('password');
            $device_id = $request->input('device_id');
            if(!isset($device_id)){
                return response()->json(['success'=>false, 'message' => 'Something Went Wrong']);
            }
            $user = UsersModel::where('username', '=', $username)->first();
            if (!$user) {
               return response()->json(['success'=>false, 'message' => 'Login Fail, please check username']);
            }
            if (!Hash::check($password, $user->password)) {
               return response()->json(['success'=>false, 'message' => 'Login Fail, pls check password']);
            }
            if($user->user_banned == '1'){
                return response()->json(['success'=>false, 'message' => 'Your Account has been banned by the Administrator']);
            }
            if($user->device_id != $device_id){
                return response()->json(['success'=>false, 'message' => 'Please Log in Throught the registered Device']);
            }

            $user = $user->where('u_id', $user->u_id)->update(['api_token'=>Str::random(60)]);
            $user = UsersModel::where('username', '=', $username)->first();
            return response()->json(['success'=>true,'message'=>'Login Successfully', 'data' => array(
                'id'=>$user->u_id,
                'username'=>$user->username,
                'email'=>$user->email,
                'mobile'=>$user->mobile,
                'points'=>$user->points == null ? "0" : $user->points,
                'coins'=>$user->coins == null ? "0" : $user->coins,
                'ref_code'=>$user->ref_code,
                'country'=>$user->country,
                'coin_address'=>$user->coin_address == null ? "" : $user->coin_address,
                'api_token'=>$user->api_token,
                'email_verified'=>$user->email_verified == null ? "0" : $user->email_verified,
            )]);   
        }
    }

    public function logout(Request $request){
        if( $request->is('api/*')){
            $response = array('response' => 'something went wrong', 'success'=>false);
            if($request->u_id == '' || !isset($request->u_id)){
                return response()->json($response);
            }
            if(UsersModel::where('u_id', $request->u_id)->update(['api_token'=>Str::random(60)])){
                return response()->json(['response'=>'Logout Successfully','success'=>true]);
            }   
        }
    }

    public function profile_update(Request $request){
        if( $request->is('api/*')){
            $data = $request->json()->all();
            $id =  $request->u_id;
            $response = array('response' => 'something went wrong', 'success'=>false);
            $rules = [
                'username' => "required|alpha_dash|unique:tbl_users,username,$id,u_id",
                'email' => "required|email|unique:tbl_users,email,$id,u_id",
                'mobile' => "required|integer|unique:tbl_users,mobile,$id,u_id",
                'mobile_verified'=>'required',
                'country'=>'required',
            ];
            $validator = Validator::make($data, $rules);
            if ($validator->passes()) {
                $data['ref_code'] = $data['username'];
                UsersModel::where('u_id',$id)->update($data);
                $response['response'] = 'User Updated Successfully';
                $response['success'] = true;
                return response()->json($response);
            }else{
                $response['response'] = $validator->errors()->messages();
                return response()->json($response);
            }
        }        
    }

    public function update_password(Request $request){
        if( $request->is('api/*')){
            $data = $request->json()->all();
            $user = UsersModel::where('u_id', '=', $request->u_id)->first();
            if (!$user) {
               return response()->json(['success'=>false, 'message' => 'Something Went Wrong']);
            }
            if (!Hash::check($data['current_password'], $user->password)) {
                return response()->json(['success'=>false, 'message' => "Password Doesn't Match"]);
            }
            else{
                $rules = ['password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',];
                $validator = Validator::make($data, $rules);
                if ($validator->passes()) {
                    if(UsersModel::where('u_id','=',$request->u_id)->update(['password'=>Hash::make($data['password'])])){
                        return response()->json(['success'=>true, 'message' => "Password Updated Successfully"]);
                    }
                    return response()->json(['success'=>false, 'message' => 'Something Went Wrong']);
                }else{
                    $response['response'] = $validator->errors()->messages();
                    return response()->json($response);
                }
            }
        }
    }

    public function referesh_profile_data(Request $request){
        $user = UsersModel::where('u_id','=',$request->u_id)->first();
        $data = [
            'data' => [
                'id'=>$user->u_id,
                'username'=>$user->username,
                'email'=>$user->email,
                'mobile'=>$user->mobile,
                'points'=>$user->points == null ? "0" : $user->points,
                'coins'=>$user->coins == null ? "0" : $user->coins,
                'ref_code'=>$user->ref_code,
                'country'=>$user->country,
                'coin_address'=>$user->coin_address == null ? "" : $user->coin_address,
                'api_token'=>$user->api_token,
                'email_verified'=>$user->email_verified == null ? "0" : $user->email_verified,
            ]
        ];
        return response($data);
    }

    public function send_email_verification($email,$verification){
        Mail::to($email)->send(new VerifyEmail($verification));
    }

    public function verify_email(){
        $slug = request()->segment(count(request()->segments()));
        UsersModel::where('verification_code',$slug)->update(['email_verified'=>'1']);
        return view('template.EmailVerified');
    }

    public function get_reset_token(Request $request){
        if( $request->is('api/*')){
            $data = $request->json()->all();
            $user = UsersModel::where(['mobile'=>$data['mobile'],'country'=>$data['country']])->first();
            if(!$user){
                return response()->json(['success'=>false, 'message' => 'Something Went Wrong']);
            }
            return response()->json(['success'=>true, 'data' => [
                'reset_token' => $user->reset_token
            ]]);
        }
    }

    public function password_reset(Request $request){
        if( $request->is('api/*')){
            $data = $request->json()->all();
            $user = UsersModel::where('reset_token',$data['reset_token'])->first();
            if(!isset($user)){
                return response()->json(['success'=>false, 'message' => 'Something Went Wrong']);
            }
            $rules = ['password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',];
            $validator = Validator::make($data, $rules);
            if ($validator->passes()) {
                if(UsersModel::where('u_id','=',$user->u_id)->update(['password'=>Hash::make($data['password'])])){
                    return response()->json(['success'=>true, 'message' => "Password Updated Successfully"]);
                }
                return response()->json(['success'=>false, 'message' => 'Something Went Wrong']);
            }else{
                $response['response'] = $validator->errors()->messages();
                return response()->json($response);
            }
        }
    }
    
}
