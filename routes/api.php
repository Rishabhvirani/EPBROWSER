<?php
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Module\Users;
use App\Http\Livewire\Module\Settings\Settings;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('/registerr',[UsersController::class,'register']);
Route::prefix('users')->group(function () {
    Route::middleware(['AuthKey'])->group(function () {
        Route::post('/logout',[Users::class,'logout']);    
        Route::post('/profile_update',[Users::class,'profile_update']);
        Route::post('/update_password',[Users::class,'update_password']);
        Route::post('/referesh_profile_data',[Users::class,'referesh_profile_data']);
        Route::post('/get_referal_users',[Users::class,'get_referal_users']);
        Route::post('/truncate_users',[Users::class,'truncate_users']);
        Route::post('/toggle_user_status',[Users::class,'toggle_user_status']);
        Route::post('/get_point_hisotry',[Users::class,'get_point_hisotry']);
        Route::post('/get_notification',[Users::class,'get_notification']);
        Route::post('/seen_notifications',[Users::class,'seen_notifications']);
        Route::post('/update_last_active',[Users::class,'update_last_active']);
        Route::post('/convert_points',[Users::class,'convert_points']);
        Route::post('/get_conversion_history',[Users::class,'get_conversion_history']);
        Route::post('/resend_email_verification',[Users::class,'resend_email_verification']);
        
    });
    
    Route::post('/check_user_details',[Users::class,'check_user_details']);
    Route::post('/register',[Users::class,'register']);
    Route::post('/login',[Users::class,'login']);    
    Route::post('/get_reset_token',[Users::class,'get_reset_token']);     
    Route::post('/password_reset',[Users::class,'password_reset']);    
});


Route::prefix('settings')->group(function () {
    Route::post('/get_settings',[Settings::class,'get_settings']);
    Route::post('/get_ad_settings',[Settings::class,'get_ad_settings']);
    Route::post('/get_bookmarks',[Settings::class,'get_bookmarks']);
});










Route::get('/details',function(){
    return ['message'=>'hello'];
});



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::middleware('auth:buser')->post('/users',function(Request $request){
    // return $request-
// });