<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserDataController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

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
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('showRegister');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verifyEmail');

Route::get('login', [AuthController::class, 'showLoginForm'])->name('showLogin');
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::get('/', [ShopController::class,'index'])->name('index');
Route::get('/detail/{shop_id}', [ShopController::class,'detail'])->name('detail');
Route::get('/search', [ShopController::class,'search']);


Route::middleware('auth')->group(function () {
    Route::get('/thanks', [AuthController::class, 'thanks'])->name('thanks');
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    Route::post('/toggle-favorite', [ShopController::class,'toggleFavorite']);
    Route::post('/done', [ReservationController::class,'thanks']);
    Route::get('/mypage', [UserDataController::class,'myPage'])->name('mypage');
    Route::get('/reservation/{shop_id}', [ReservationController::class,'edit'])->name('editReservation');
    Route::patch('/reservation/update', [ReservationController::class, 'update'])->name('updateReservation');
    Route::delete('/reservation/destroy',[ReservationController::class, 'destroy'])->name('destroyReservation');
    Route::get('/mypage/history', [UserDataController::class,'myPageHistory'])->name('history');
    Route::post('/mypage/history/rank', [UserDataController::class,'rank'])->name('rank');
});

Route::prefix('admin')->group(function ()
{
    Route::get('login', [AdminController::class, 'showLoginForm'])->name('showAdminLogin');
    Route::post('login', [AdminController::class, 'login'])->name('adminLogin');
    Route::get('logout', [AdminController::class, 'logout'])->name('adminLogout');
});

Route::middleware('auth:admins')->group(function ()
{
    Route::get('/admin', [AdminController::class, 'admin'])->name('admin');
});
