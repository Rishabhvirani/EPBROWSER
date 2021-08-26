<?php
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Module\Users;
use App\Http\Livewire\Module\Settings\Settings;
use App\Http\Livewire\Module\Bookmarks;
use App\Http\Livewire\Module\Withdrawal;
use App\Http\Livewire\Module\Timer;
use App\Http\Livewire\Module\UserHistory;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



// $router->pattern('id', '[0-9]+');
Route::get('/verify_email/{id}',[Users::class,'verify_email']);
// Route::POST('users/get_users',[Users::class,'get_users']);
Route::middleware(['auth:sanctum', 'verified'])->get('/users/history/{id}', [Users::class,'get_user_history'])->name('User History');
Route::middleware(['auth:sanctum', 'verified'])->get('/users/check_entries', [Users::class,'check_entries'])->name('Check Entries');

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/users/history/{id}', UserHistory::class)->name('User History');
Route::middleware(['auth:sanctum', 'verified'])->get('/timer', Timer::class)->name('Timer');
Route::middleware(['auth:sanctum', 'verified'])->get('/withdrawal', Withdrawal::class)->name('Withdrawal');
Route::middleware(['auth:sanctum', 'verified'])->get('/bookmarks', Bookmarks::class)->name('Bookmarks');
Route::middleware(['auth:sanctum', 'verified'])->get('/settings', Settings::class)->name('Settings');
Route::middleware(['auth:sanctum', 'verified'])->get('/users', Users::class)->name('Users');
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard',Dashboard::class)->name('dashboard');