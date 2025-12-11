<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users', [UserController::class, 'Users'])->name('users');
    Route::get('/add-users', [UserController::class, 'addUser'])->name('add.users');
    Route::get('/get-subeducation', [UserController::class, 'getSubeducation'])->name('get.subeducation');
    Route::post('/create-user', [UserController::class, 'createUser'])->name('create.user');
    Route::post('/change-user-password', [UserController::class, 'changeuserPassword'])->name('change.user.password');
    Route::delete('/delete-user-account', [UserController::class, 'deleteuserAccount'])->name('delete.user.account');
    Route::post('/users/download-csv', [UserController::class, 'downloadCsv'])->name('users.csv.download');
    Route::get('/view/profile/{id}', [UserController::class, 'viewProfile'])->name('view.profile');
    Route::get('/edit/profile/{id}', [UserController::class, 'editProfile'])->name('edit.profile');
    Route::post('/update/profile', [UserController::class, 'updateProfile'])->name('update.profile');
    Route::get('/deleted-users', [UserController::class, 'deletedUser'])->name('deleted.users');
    Route::put('/users/restore/{id}', [UserController::class, 'restore'])->name('user.restore');

    Route::get('/create-job', [JobController::class, 'createJob'])->name('create.job');
    Route::post('/get-currency', [JobController::class, 'getCurrency'])->name('get.currency');



    Route::get('/change-password', [ChangePasswordController::class, 'index'])->name('change.password');
    Route::post('/update-password', [ChangePasswordController::class, 'updatePassword'])->name('update.password');


});

require __DIR__.'/auth.php';
