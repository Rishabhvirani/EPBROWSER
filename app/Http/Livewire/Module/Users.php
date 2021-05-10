<?php
namespace App\Http\Livewire\Module;
use App\Models\UsersModel;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SettingsModel;
use App\Models\PointHistoryModel;
use App\Models\NotificationModel;
use App\Models\ConversionModel;
// use App\Mail\OrderShipped;
use Illuminate\Support\Facades\DB;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use App\Rules\Referal;
use Carbon\Carbon;


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
        'lat'=>'required',
        'long'=>'required',
        'device_id'=>'required|unique:tbl_users',
    ];

    public function render()
    {
        return view('livewire.module.users');
    }

    public function check_user_details(Request $request){
        $data = $request->json()->all();
        $this->rules['ref_code'] = [new Referal($data)];
        $validator = Validator::make($data, $this->rules);
        if ($validator->passes()) {
            $response['success'] = true;
            return response()->json($response);
        }else{
            $response['message'] = $validator->errors()->first();
            $response['success'] = false;
            return response()->json($response);            
        }
    }

    public function register(Request $request){
        $userModel =  new UsersModel;
        $settings =  new SettingsModel;
        $refdata['label'] = 'referal';
        $ref_setting = $settings->get_settings($refdata);
        $response = array('success'=>false);
        if( $request->is('api/*')){
            $response = array('response' => '','success'=>false);
            $data = $request->json()->all();
            $this->rules['ref_code'] = [new Referal($data)];
            $validator = Validator::make($data, $this->rules);
            if ($validator->passes()) {
                if($ref_setting->isReferalActive == 1){   
                    $ref_user =  UsersModel::where('ref_code','=',strtolower($data['ref_code']))->where('status','0')->first();
                    if(isset($ref_user->u_id)){
                        $data['ref_id'] = $ref_user->u_id;    
                        $data['points'] = $ref_setting->childEarning;   
                        UsersModel::where(array('u_id'=>$data['ref_id']))->update(['points' => DB::raw('points + '.$ref_setting->parentEarning)]);
                    }
                }
                $user = $userModel->Prepare_User($data);
                $user = UsersModel::create($user);
                if($user){
                    if(config('app.env') === 'production'){
                        $this->send_email_verification($user->email,$user->verification_code);
                    }
                    if(isset($ref_user->u_id) && $ref_setting->isReferalActive == 1){
                        $this->insert_point_history($user->ref_id,$user->u_id);
                    }
                    $response=array(
                        'success'=>true,
                        'message'=>'User Created Successfully',
                        'data'=> array(
                            'id'=>$user->u_id,
                            'username'=>$user->username,
                            'email'=>$user->email,
                            'mobile'=>$user->mobile,
                            'points'=>$user->points == null ? "0" : $user->points,
                            'coins'=>$user->coins == null ? "0" : $user->coins,
                            'ref_code'=>$user->ref_code,
                            'usd'=>$user->usd ==  null ? "0" : $user->usd,
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
                unset($response['response']);
                $response['message'] = $validator->errors()->first();
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
                'reset_token'=>Str::random(80),
                'device_id'=>Str::random(8),
                ]
            );
            $this->reset();
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'success',  'message' => 'User Created']);
            
        }   
    }

    public function insert_point_history($parent_user,$child_user){
        $settings =  new SettingsModel;
        $ref_setting = $settings->get_settings(array('label'=>'referal'));

        
            PointHistoryModel::create(array(
                    'user_id'=>$child_user,
                    'point'=>$ref_setting->childEarning,
                    'earn_type'=>'r',
                    'ref_type'=>'c',
                ));

            NotificationModel::create(
                array(
                    'sender'=>$parent_user,
                    'receiver'=>$child_user,
                    'n_type'=>'r',
                    'ref_type'=>'c',
                    'points'=>$ref_setting->childEarning,
                )
            );


            PointHistoryModel::create(array(
                'user_id'=>$parent_user,
                'point'=>$ref_setting->parentEarning,
                'earn_type'=>'r',
                'ref_type'=>'p',
            ));

            NotificationModel::create(
                array(
                    'sender'=>$child_user,
                    'receiver'=>$parent_user,
                    'n_type'=>'r',
                    'ref_type'=>'p',
                    'points'=>$ref_setting->parentEarning,
                )
            );

            return true;
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
            // if($user->device_id != $device_id){
            //     return response()->json(['success'=>false, 'message' => 'Please Log in Throught the registered Device']);
            // }
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
                'usd'=>$user->usd ==  null ? "0" : $user->usd,
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
            $data['ref_code'] = $data['username'];
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
                'usd'=>$user->usd ==  null ? "0" : $user->usd,
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

    public function truncate_users(){
        if(UsersModel::truncate()){
            return response()->json(['success'=>true, 'message' => 'all users deleted']);
        }
    }

    public function get_referal_users(Request $request){
        if( $request->is('api/*')){
            $user = UsersModel::select('username','last_active','email','created_at')->where(array('ref_id'=>$request->u_id,'status'=>'0','user_banned'=>'0'));
            if($user->count() == 0){
                // $data['data'] 
                // 'data'=> {'ref_user_count':0,'ref_user_data':[]}
                 $data = json_encode(array('data'=>[]));
                return response()->json(['success'=>true, 'message' => 'Zero Users','data'=>json_decode('{}')]);
            }else{
                $data['ref_user_count'] = $user->count();
                $data['ref_user_data'] = $user->get();
                $user_data;
                $ref_user_data = $user->get();
                foreach($ref_user_data as $i=>$ref_user){   
                    $data['ref_user_data'][$i]->email = $this->star_email($ref_user->email);
                    $data['ref_user_data'][$i]->last_active = isset($ref_user->last_active) ? $ref_user->last_active : '';
                }
                return response()->json(['success'=>true, 'data' => $data]);
            }
        }
    }

    public function toggle_user_status(Request $request){
        if( $request->is('api/*')){
            if(UsersModel::Where(array('u_id'=>$request->u_id))->update(array('is_active'=>$request->is_active))){
                return response()->json(['success'=>true, 'message' => 'success']);
            }
        }   
    }

    public function star_email($email)
    {
        return substr($email, 0, 2) . str_repeat('*', ($at_pos = strpos($email,'@')) - 3) . substr($email, $at_pos - 1);
    }

    public function get_point_hisotry(Request $request){
        $pointHistory = PointHistoryModel::where(array('user_id'=>$request->u_id,'status'=>'0'))->get()->map(
            function($data) {
                if(!$data->timer_id){
                    $data->timer_id = "";
                }
                return $data;
            });
        
        return response()->json(['success'=>true, 'data' => $pointHistory]);
    }

    public function get_notification(Request $request){
        $total_count = NotificationModel::where(array('receiver'=>$request->u_id))->count();
        if($total_count == 0){
            return response()->json(['success'=>true, 'message' => 'Zero Notification','data'=>json_decode('{}')]);
        }
        $notifications = DB::table('tbl_notification')
        ->join('tbl_users','tbl_notification.sender','=','tbl_users.u_id','left')
        ->where(array('tbl_notification.receiver'=>$request->u_id))
        ->select('tbl_notification.*','tbl_users.username')
        ->orderByDesc('tbl_notification.n_id')
        ->get()
        ->map(function($data) {
            if (!$data->sender) {
                $data->sender = '';
            }
            if (!$data->ref_type) {
                $data->ref_type = '';
            }
            if (!$data->coins) {
                $data->coins = '';
            }
            if (!$data->timer) {
                $data->timer = '';
            }
            if (!$data->data) {
                $data->data = '';
            }
            if (!$data->username) {
                $data->username = '';
            }
            if (!$data->usd) {
                $data->usd = '';
            }
            return $data;
        });
        $unseen_count = NotificationModel::where(array('receiver'=>$request->u_id,'is_read'=>'0'))->count();
        $data['unseen_count'] = $unseen_count;
        $data['notifications']=$notifications;
        return response()->json(['success'=>true, 'data' => $data]); 
    }

    public function seen_notifications(Request $request){
        $unseen_count = NotificationModel::where(array('receiver'=>$request->u_id,'is_read'=>'0'))->update(array('is_read'=>'1'));
        return response()->json(['success'=>true]); 
    }

    public function update_last_active(Request $request){
        UsersModel::where(array('u_id'=>$request->u_id))->update(array('last_active'=>now()));
    }

    public function convert_points(Request $request){

        $data = $request->json()->all();
        $data['u_id'] = $request->u_id;
        $settingModel = new SettingsModel();
        $conversion_settings = $settingModel->get_settings(array('label'=>'conversion'));
        $MinConversion = (int)$conversion_settings->MinConversion;
        $ConversionRate = explode(":",$conversion_settings->ConversionRate);
        $points = $ConversionRate[0];
        $usd = $ConversionRate[1];
        $data['conversionRate'] = $conversion_settings->ConversionRate;
        $data['usd'] = $data['points'] / $points * $usd;

        if($data['points'] < $MinConversion){
            return response()->json(['success'=>true,'message'=>"You need minimum $conversion_settings->MinConversion candy for conversion"]); 
        }

        $user_data = UsersModel::select('points','usd')->where(array('u_id'=>$request->u_id))->first();
        if($data['points'] > $user_data->points){
            return response()->json(['success'=>true,'message'=>'You have only ' .$user_data->points .' candy']); 
        }
        $update_data = array(
            'usd'=>DB::raw('`usd`+'.$data['usd']),
            'points'=>DB::raw('`points`'.'-'.$data['points']),
        );
        $conversionHistory = ConversionModel::create($data);
        if(isset($conversionHistory)){
            UsersModel::where(array('u_id'=>$request->u_id))->update($update_data);
            NotificationModel::create(
                [
                    'receiver'=>$request->u_id,
                    'n_type'=>'c',
                    'points'=>$data['points'],
                    'usd'=>$data['usd'],
                    'data'=>$conversionHistory->id,
                ]
            );
        }
        return response()->json(['success'=>true,'message'=>'Points Converted Successfully']); 
    }


    public function get_conversion_history(Request $request){
        
        $conversion_history = ConversionModel::where(array('u_id'=>$request->u_id))->get();
        return response()->json(['success'=>true,'data'=>$conversion_history]); 
    }

}