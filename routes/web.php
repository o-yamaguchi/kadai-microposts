<?php

// use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController; // 追記
use App\Http\Controllers\MicropostsController; //追記
use App\Http\Controllers\UserFollowController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('dashboard');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
// ↓変更後
Route::get('/', [MicropostsController::class, 'index']);

Route::get('/dashboard', [MicropostsController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::prefix('users/{id}')->group(function () {
        Route::post('follow', [UserFollowController::class, 'store'])->name('user.follow');
        Route::delete('unfollow', [UserFollowController::class, 'destroy'])->name('user.unfollow');
        Route::get('followings', [UsersController::class, 'followings'])->name('users.followings');
        Route::get('followers', [UsersController::class, 'followers'])->name('users.followers');
    });
    
    Route::resource('users', UsersController::class, ['only' => ['index', 'show']]);
    Route::resource('microposts', MicropostsController::class, ['only' => ['store', 'destroy']]);
});

require __DIR__.'/auth.php';
