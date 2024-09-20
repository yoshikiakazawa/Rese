<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserDataController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\AuthOwnerController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StripePaymentsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CreateShopController;

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

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('showLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');

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
    Route::post('/payment', [StripePaymentsController::class, 'payment'])->name('pay');
    Route::get('/review/{shop_id}', [ReviewController::class, 'show'])->name('showReview');
    Route::post('/review/{shop_id}/store', [ReviewController::class, 'store'])->name('storeReview');
    Route::post('/review/{id}/edit', [ReviewController::class, 'edit'])->name('editReview');
    Route::post('/review/destroy', [ReviewController::class, 'destroy'])->name('deleteReview');
});

Route::prefix('admin')->group(function ()
{
    Route::get('/login', [AuthAdminController::class, 'showLoginForm'])->name('showAdminLogin');
    Route::post('/login', [AuthAdminController::class, 'login'])->name('adminLogin');

});

Route::middleware('auth:admins')->group(function ()
{
    Route::post('/admin/logout', [AuthAdminController::class, 'logout'])->name('adminLogout');
    Route::get('/admin', [AdminController::class, 'admin'])->name('admin');
    Route::post('/admin/store', [AdminController::class, 'store'])->name('storeOwner');
    Route::get('/admin/detail/{owner_id}', [AdminController::class, 'detail'])->name('detailOwner');
    Route::get('/admin/send-notification', [NotificationController::class, 'showForm'])->name('admin.send-notification');
    Route::post('/admin/send-notification', [NotificationController::class, 'sendNotification']);
    Route::post('/admin/csv-upload', [CreateShopController::class, 'upload'])->name('upload');
});

Route::prefix('owner')->group(function ()
{
    Route::get('login', [AuthOwnerController::class, 'showLoginForm'])->name('showOwnerLogin');
    Route::post('login', [AuthOwnerController::class, 'login'])->name('ownerLogin');
});

Route::middleware('auth:owners')->group(function ()
{
    Route::post('/owner/logout', [AuthOwnerController::class, 'logout'])->name('ownerLogout');
    Route::get('/owner', [OwnerController::class, 'index'])->name('owner');
    Route::post('/owner/store', [CreateShopController::class, 'store'])->name('storeShop');
    Route::get('/owner/show/{id}', [OwnerController::class, 'show'])->name('showShop');
    Route::get('/owner/history/{id}', [OwnerController::class, 'history'])->name('reservationHistory');
    Route::get('/owner/past-history/{id}', [OwnerController::class, 'pastHistory'])->name('reservationPastHistory');
    Route::post('/owner/edit', [CreateShopController::class, 'edit'])->name('editShop');
    Route::post('/amount', [StripePaymentsController::class, 'amount'])->name('amount');
});
