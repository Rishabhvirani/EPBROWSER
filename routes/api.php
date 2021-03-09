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



Route::prefix('')->group(function () {
    Route::middleware(['Authkey'])->group(function () {
        Route::get('/hello',[Users::class,'hello']);
    });
    Route::post('/register',[Users::class,'register']);
    Route::post('/login',[Users::class,'login']);    
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