<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminLoginController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('admin/dashboard', function() {
//     return view('admin.dashboard');
// });

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth', 'admin']], function() {
    Route::resource('dashboard', DashboardController::class)->only([
        'index'
    ]);
    Route::resources([
        'user' => UserController::class,
        'tag' => TagController::class,
        'category' => CategoryController::class,
        'post' => PostController::class
    ]);
});

Route::group(['prefix' => 'admin'], function() {
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('admin.showloginform');
    Route::post('adminlogin', [AdminLoginController::class, 'authenticate'])->name('admin.login');
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
});
