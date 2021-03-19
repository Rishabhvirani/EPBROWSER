<?php
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Module\Users;


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
        Route::post('/truncate_users',[Users::class,'truncate_users']);
    });
    Route::post('/register',[Users::class,'register']);
    Route::post('/login',[Users::class,'login']);    
    Route::post('/get_reset_token',[Users::class,'get_reset_token']);     
    Route::post('/password_reset',[Users::class,'password_reset']);    
    
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