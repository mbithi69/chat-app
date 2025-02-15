<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard', [
      'users' => User::where('id', '!=', Auth::id())->get()
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/chat/{user}', function (User $user){
    return view('chat', [
        'user' => $user
    ]);
})->middleware(['auth', 'verified'])->name('chat');

Route::resource(
    'messages/{user}', 
    ChatController::class, ['only' => ['index', 'store']]
)->middleware(['auth']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
