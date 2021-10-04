<?php
namespace App\Http\Livewire\Module;
use App\Models\UsersModel;
use App\Models\TimerModel;
use App\Models\TimerHistoryModel;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SettingsModel;
use App\Models\PointHistoryModel;
use App\Models\NotificationModel;
use App\Models\WithdrawalModel;
use App\Models\ConversionModel;
use Illuminate\Support\Facades\DB;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use App\Rules\Referal;
use Carbon\Carbon;


class Users extends Component
{
    public $users;
    protected $listeners = ['userCreated' => 'render'];
    public $rules = [
        'username' => 'required|alpha_dash|unique:tbl_users',
        'email' => 'required|email|unique:tbl_users',
        'password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@#%]).*$/',
        'mobile' => 'required|integer|unique:tbl_users',
        'mobile_verified'=>'required',
        'country'=>'required',
        'lat'=>'required',
        'long'=>'required',
        'device_id'=>'required|unique:tbl_users',
    ];
    public $messages = [
        'password.regex' => 'Your password must contain at least one number, special character and have a mixture of uppercase and lowercase letters.',
    ];

    public function render()
    {
        $this->users = UsersModel::where(array('status'=>'0'))->OrderBy('u_id','DESC')->get();
        return view('livewire.module.users');
    }

    public function get_users(Request $request){
        $users = UsersModel::where(array('status'=>'0'))->OrderBy('u_id','DESC')->get();
        $search = $request->query('search', array('value' => '', 'regex' => false));
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(1, 'asc'));  
        $filter = $search['value'];
        $json = array(
            'draw' => $draw,
            'recordsTotal' => 1000,
            'recordsFiltered' => 20,
            'data' => [],
        );
        foreach ($users as $user) {

            $json['data'][] = [
                $user->username,
                $user->email,
                $user->mobile,
                $user->points,
                $user->usd,
                $user->country,
                $user->email_verified,
                $user->mobile_verified,
                "<td><span data-toggle='modal' data-target='#edit' wire:click='openEdit($user->u_id)' wire:key='$user->u_id' class='badge badge-warning'>Edit</span></td>",
            ];
        }
        return $json;
    }

    public function get_user_history(Request $request){

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
            $validator = Validator::make($data, $this->rules,$this->messages);
            if ($validator->passes()){
                // if($ref_setting->isReferalActive == 1){
                    $ref_user =  UsersModel::where('ref_code','=',strtolower($data['ref_code']))->where('status','0')->first();
                    if(isset($ref_user->u_id)){
                        $data['ref_id'] = $ref_user->u_id;    
                        // $data['points'] = $ref_setting->childEarning;   
                        // UsersModel::where(array('u_id'=>$data['ref_id']))->update(['points' => DB::raw('points + '.$ref_setting->parentEarning)]);
                    }
                // }
                $user = $userModel->Prepare_User($data);
                $user = UsersModel::create($user);
                if($user){
                    // if(config('app.env') === 'production'){
                        $this->send_email_verification($user->email,$user->verification_code);
                    // }
                    $response=array(
                        'success'=>true,
                        'message'=>'User Created Successfully',
                        'data'=> array(
                            'id'=>$user->u_id,
                            'username'=>$user->username,
                            'email'=>$user->email,
                            'mobile'=>$user->mobile,
                            'points'=>'0',
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
        }   
    }

    public function openEdit($u_id){
        $this->emit('openEdit',$u_id);
    }

    public function insert_point_history($parent_user,$child_user){
        $settings =  new SettingsModel;
        $ref_setting = $settings->get_settings(array('label'=>'referal'));
        
            if($ref_setting->childEarning > 0){
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
            }
            
            if($ref_setting->parentEarning > 0 && $ref_setting->isReferalActive == '1'){
                PointHistoryModel::create(array(
                    'user_id'=>$parent_user,
                    'point'=>$ref_setting->parentEarning,
                    'earn_type'=>'r',
                    'ref_type'=>'p',
                    'child_id'=>$child_user
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
            }
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
            // if(){
            // if($user->device_id != $device_id && config('app.env') === 'production'){
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
            $data['ref_code'] = strtolower($data['username']);
            $validator = Validator::make($data, $rules);
            if ($validator->passes()) {
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
                $rules = ['password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@#%]).*$/',];
                $validator = Validator::make($data, $rules,$this->messages);
                if ($validator->passes()) {
                    $token = Str::random(60);
                    if(UsersModel::where('u_id','=',$request->u_id)->update(['password'=>Hash::make($data['password']),'api_token'=>$token])){
                        return response()->json(['success'=>true, 'message' => "Password Updated Successfully",'api_token'=>$token]);
                    }
                    return response()->json(['success'=>false, 'message' => 'Something Went Wrong']);
                }else{
                    $response['success'] = false;
                    $response['message'] = $validator->errors()->first();
                    return response()->json($response);
                    // $response['response'] = $validator->errors()->messages();
                    // return response()->json($response);
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

    public function resend_email_verification(Request $request){
        $user_data = UsersModel::select('verification_code','email')->where(array('u_id'=>$request->u_id))->first();    
        Mail::to($user_data->email)->send(new VerifyEmail($user_data->verification_code));
        return response()->json(['success'=>true, 'message' => "Your Verification Email has been sent."]);
        
    }

    public function verify_email(){
        $slug = request()->segment(count(request()->segments()));
        $user = UsersModel::where('verification_code',$slug)->first();
        if($user->email_verified == 1){
            return view('template.EmailVerified');
        }
        UsersModel::where('verification_code',$slug)->update(['email_verified'=>'1']);
        $settings =  new SettingsModel;
        $refdata['label'] = 'referal';
        $ref_setting = $settings->get_settings($refdata);
        UsersModel::where('u_id',$user->u_id)->update(['points'=>$ref_setting->childEarning]);
        if($ref_setting->isReferalActive == '1'){
            UsersModel::where('u_id',$user->ref_id)->update(['points' => DB::raw('points + '.$ref_setting->parentEarning)]);
        }
        $this->insert_point_history($user->ref_id,$user->u_id);
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
            $rules = ['password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@#%]).*$/',];
            $validator = Validator::make($data, $rules,$this->messages);
            if ($validator->passes()) {
                
                if(UsersModel::where('u_id','=',$user->u_id)->update(['password'=>Hash::make($data['password'])])){
                    return response()->json(['success'=>true, 'message' => "Password Updated Successfully"]);
                }
                return response()->json(['success'=>false, 'message' => 'Something Went Wrong']);
            }else{
                $response['success'] = false;
                $response['message'] = $validator->errors()->first();
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
                 $data = json_encode(array('data'=>[]));
                return response()->json(['success'=>true, 'message' => 'Zero Users','data'=>json_decode('{}')]);
            }else{
                $data['ref_user_count'] = $user->count();
                $data['ref_user_data'] = $user->get();
                
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
        $pointHistory = PointHistoryModel::where(array('user_id'=>$request->u_id,'status'=>'0'))->OrderBy('ph_id','desc')->get()->map(
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
        NotificationModel::where(array('receiver'=>$request->u_id,'is_read'=>'0'))->update(array('is_read'=>'1'));
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


    public function withdrawal_request(Request $request){
        $data = $request->json()->all();
        $data['u_id'] = $request->u_id;
        $settingModel = new SettingsModel();
        $withdrawal_settings = $settingModel->get_settings(array('label'=>'Withdrawal'));
        $user_data = UsersModel::select('email_Verified','user_banned','mobile_Verified','usd')->where(array('u_id'=>$request->u_id))->first();
        if($user_data->user_banned == '1'){
            return response()->json(['success'=>false,'message'=>'Your have been banned by the admin']); 
        }
        if($user_data->email_Verified == 0 ){
            return response()->json(['success'=>false,'message'=>'Your Email address must be verified']); 
        }
        if($data['usd'] < $withdrawal_settings->MinWithdrawal ){
            return response()->json(['success'=>false,'message'=>'You must have to withdraw minimum ' . $withdrawal_settings->MinWithdrawal . ' USD']); 
        }
        if($data['usd'] > $user_data->usd ){
            return response()->json(['success'=>false,'message'=>'Your cuurent balance is ' .$user_data->usd. ' USD']); 
        }
        $insert_data =  array(
           'user_id'=>$request->u_id,
           'usd'=>$data['usd'],
           'epc'=> $data['usd']/(float)$withdrawal_settings->epc_rate,
           'epc_address'=> $data['epc_address'],
        );
        if(WithdrawalModel::Create($insert_data)){
            $update_data = array(
                'usd'=>DB::raw('`usd`-'.$data['usd']),
            );
            UsersModel::where(array('u_id'=>$request->u_id))->update($update_data);
            return response()->json(['success'=>true,'message'=>'Your Withdrawal Request has been Generated']); 
        }else{
            return response()->json(['success'=>false,'message'=>'Something went Wrong']); 
        }
    }

    public function withdrawal_history(Request $request){
        $data = $request->json()->all();
        $data['u_id'] = $request->u_id;
        $withdrawal_history = WithdrawalModel::where(array('user_id'=>$request->u_id))->get();
        return response()->json(['success'=>true,'data'=>$withdrawal_history]);
    }

    public function start_timer(Request $request){
        $today = '%'.Date('Y-m-d').'%';
        $todaystimer = TimerHistoryModel::where(array('user_id'=>$request->u_id))->where('created_at','like',$today)->OrderBy('th_id','DESC')->first();
        
        if(!isset($todaystimer) || $todaystimer == null){
            $request->t_id = 1;
        }else if($todaystimer->status == 1){
            if($todaystimer->status == 0){
                return response()->json(['success'=>false,'message'=>"Timer $todaystimer->timer_id is already Running"]);
            }
            $request->t_id = $todaystimer->timer_id + 1;
        }

        $t_details =TimerModel::where(array('t_id'=>$request->t_id))->first();
        $counter = TimerHistoryModel::where(array('timer_id'=>$request->t_id,'user_id'=>$request->u_id))->where('created_at','like',$today)->get()->count();
        if($counter > 0){
            return response()->json(['success'=>false,'message'=>'Timer is already Started']);
        }
        $data = array(
            'user_id'=>$request->u_id,
            'timer_id'=>$request->t_id,
            'points'=>$t_details->points,
        );
        if(TimerHistoryModel::create($data)){
            return response()->json(['success'=>true,'message'=>"Timer $request->t_id Started Successfully"]);
        }else{
            return response()->json(['success'=>false,'message'=>'Something went wrong']);
        }
    }

    public function claim_timer(Request $request){
        $today = '%'.Date('Y-m-d').'%';
        $todaystimer = TimerHistoryModel::where(array('user_id'=>$request->u_id))->where('created_at','like',$today)->OrderBy('th_id','DESC')->first();
        if(!isset($todaystimer) || $todaystimer == null){
            return response()->json(['success'=>false,'message'=>"No Timer is Started yet on current date"]);
        }
        $request->t_id = $todaystimer->timer_id;
        if($todaystimer->status == "1" ){
            return response()->json(['success'=>false,'message'=>"Timer $todaystimer->timer_id is already Claimed"]);
        }
        $t_details =TimerModel::where(array('t_id'=>$request->t_id))->first();
        $user =  UsersModel::where(array('u_id'=>$request->u_id))->first();
        $parent_user =  UsersModel::where(array('u_id'=>$user->ref_id))->first();
        if($user->ref_id != '' || $user->ref_id != null){
            $settings =  new SettingsModel;
            $gendata['label'] = 'general';
            $gen_setting = $settings->get_settings($gendata);
            $parent_points = (float) $request->points * $gen_setting->TimerParentEarning / 100;
            
            $child_points =(float) $request->points;
            $update_data = array(
                'status'=> '1'
            );
            $today = '%'.Date('Y-m-d').'%';
            $claim = TimerHistoryModel::where(array('timer_id'=>$request->t_id,'user_id'=>$request->u_id))->where('created_at','like',$today)->update($update_data);
            if($claim){
                // child ////////////////////////////////////////////////////////////////////////////////////////
                PointHistoryModel::create(
                    array(
                        'user_id'=>$request->u_id,  
                        'point'=>$child_points,
                        'earn_type'=>'t',
                        'ref_type'=>'c',
                        'timer_id'=>$request->t_id
                    )
                );

                $update_user_points = array(
                    'points'=>$user->points+$child_points
                );
                $user->update($update_user_points);

                NotificationModel::create(
                    array(
                        'receiver'=>$user->u_id,
                        'n_type'=>'t',
                        'ref_type'=>'c',
                        'points'=>$child_points,
                        'timer'=>$request->t_id,
                    )
                );

                // Parent //////////////////////////////////////////////////////////////////////////
                PointHistoryModel::create(
                    array(
                        'user_id'=>$user->ref_id,  
                        'point'=>$parent_points,
                        'earn_type'=>'r',
                        'ref_type'=>'p',
                        'timer_id'=>$request->t_id,
                        'child_id'=>$request->u_id,
                    )
                );

                $update_parent_points = array(
                    'points'=>$parent_user->points + $parent_points,
                );

                UsersModel::where(array('u_id'=>$user->ref_id))->update($update_parent_points);

                NotificationModel::create(
                    array(
                        'receiver'=>$user->ref_id,
                        'n_type'=>'t',
                        'ref_type'=>'p',
                        'points'=>$parent_points,
                        'timer'=>$request->t_id,
                    )
                );
            }
            return response()->json(['success'=>true,'message'=>"Congratulations, you have Completed timer $request->t_id"]);
        }
        
        $update_data = array(
            'status'=> '1'
        );
        $today = '%'.Date('Y-m-d').'%';
        $claim = TimerHistoryModel::where(array('timer_id'=>$request->t_id,'user_id'=>$request->u_id))->where('created_at','like',$today)->update($update_data);
        if($claim){
            PointHistoryModel::create(
                    array(
                        'user_id'=>$request->u_id,  
                        'point'=>$request->points,
                        'earn_type'=>'t',
                        'ref_type'=>'c',
                        'timer_id'=>$request->t_id
                    )
                );

            $update_user_points = array(
                'points'=>$user->points+$request->points
            );

            $user->update($update_user_points);

            NotificationModel::create(
                array(
                    'receiver'=>$user->u_id,
                    'n_type'=>'t',
                    'ref_type'=>'c',
                    'points'=>$request->points,
                    'timer'=>$request->t_id,
                )
            );
        }
        return response()->json(['success'=>true,'message'=>"Congratulations, you have Completed timer $request->t_id"]);
    }   

    public function get_timer(Request $request){
        $user_id = $request->u_id;
        $dataa = TimerModel::where(array('active'=>'1'))->select('t_id','timer','points','active')
        ->get()->map(function($data) use ($user_id) {
            if(!$data->claim){
                $today = '%'.Date('Y-m-d').'%';
                $T_History = TimerHistoryModel::where(array('timer_id'=>$data->t_id,'user_id'=>$user_id))->where('created_at','like',$today);
                if($T_History->count() == 1){
                    $data->points = $T_History->first()->points;
                    $data->running = $T_History->first()->status == '0' ? true : false ;
                    $data->claim = $T_History->first()->status == '1' ? true : false ;
                }else{
                    $data->running = false;
                    $data->claim = false;
                }
            }        
            return $data;
        });
        return response()->json(['success'=>true,'data'=>$dataa]);
    }

    public function check_entries(){
        $lists = DB::table('tbl_users')
        ->select('ref_id', DB::raw('count(ref_id) as count'))
        ->groupBy('ref_id')
        ->orderBy(DB::raw('count(ref_id)'),'DESC')->get();
        foreach($lists as $list){
            $total = DB::table('tbl_point_history')
            ->where(array('user_id'=>$list->ref_id,'earn_type'=>'r','ref_type'=>'p','timer_id'=>null))
            ->select(DB::raw('sum(point) as total'))
            ->first()->total;
            if($list->count != ($total/1000)){
                echo $list->ref_id . '&nbsp&nbsp&nbsp&nbsp' . $list->count ."&nbsp&nbsp&nbsp&nbsp&nbsp". $total . "<br>";
            }
        }
    }

    public function update_ref_id(){
        $lists = DB::table('tbl_users')
        ->select('ref_id', DB::raw('count(ref_id) as count'))
        ->groupBy('ref_id')
        ->orderBy(DB::raw('count(ref_id)'),'DESC')->get();
        foreach($lists as $list){
            if($list->count != 0){ 
                $notifications = DB::table('tbl_point_history')
                ->join('tbl_notification','tbl_point_history.created_at','=','tbl_notification.created_at','left')
                ->where(array('tbl_point_history.user_id'=>$list->ref_id,'tbl_notification.n_type'=>'r','tbl_notification.ref_type'=>'p','tbl_point_history.earn_type'=>'r','tbl_point_history.ref_type'=>'p','tbl_point_history.child_id'=>null))
                ->select('tbl_point_history.ph_id as ph_id','tbl_point_history.created_at as pcreate','tbl_notification.created_at as ncreate','tbl_notification.sender as sender')
                ->get();
                $ph_update = array();
                foreach($notifications as $i=>$notification){
                    PointHistoryModel::where(array('ph_id'=>$notification->ph_id))->update(array('child_id'=>$notification->sender));
                }
            }   
        }
        $notifications = DB::table('tbl_point_history')
        ->join('tbl_notification','tbl_point_history.created_at','=','tbl_notification.created_at','left')
        ->where(array('tbl_point_history.user_id'=>744,'tbl_notification.n_type'=>'r','tbl_notification.ref_type'=>'p','tbl_point_history.earn_type'=>'r','tbl_point_history.ref_type'=>'p','tbl_point_history.child_id'=>null))
        ->select('tbl_point_history.ph_id as ph_id','tbl_point_history.created_at as pcreate','tbl_notification.created_at as ncreate','tbl_notification.sender as sender')
        ->get();
        $ph_update = array();
        foreach($notifications as $i=>$notification){
            PointHistoryModel::where(array('ph_id'=>$notification->ph_id))->update(array('child_id'=>$notification->sender));
        }
    }   
 


}


