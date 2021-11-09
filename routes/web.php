<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthControllerNojwt;
use App\Http\Controllers\AdminController;
use App\Models\User;

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

Route::get('/', function () {
    return view('welcome');
});


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

Route::get('create-user', function(){

    $user = new User();
    $user->name = 'Amirul Asyraf';
    $user->email = 'amirulasyraf@invokeisdata.com';
    $user->password = bcrypt('password');
    $user->save();

    return response()->json('user created');
});

Route::get('queue-email', function(){

    $email_list['email'] = 'amirulasyraf097@gmail.com';
    $email_list['user'] = 'Amirul Asyraf';

    dispatch(new \App\Jobs\QueueJob($email_list));

	return response()->json($email_list['email']);
    // dd('Send Email Successfully');
});

Route::prefix('admin')->group(function() {
    Route::any('/', [AdminController::class, 'login']);
    Route::any('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::any('/dashboard/{group}', [AdminController::class, 'display'])->name('display');
    Route::any('/dashboard/user/edit/{id}', [AdminController::class, 'editUsers'])->name('edit.user');
    Route::any('/dashboard/user/delete/{id}', [AdminController::class, 'delete'])->name('delete');
});

