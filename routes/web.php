<?php

// namespace App\Http\Livewire\Module;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Module\Users;
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




Route::get('/verify_email/{id}',[Users::class,'verify_email']);

Route::get('/', function () {
    return redirect('/login');
});
// Route::get('/users',Users::class)->name('Users');
Route::middleware(['auth:sanctum', 'verified'])->get('/users', Users::class)->name('Users');
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
