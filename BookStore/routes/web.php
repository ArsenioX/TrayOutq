<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\PDFController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\User\UserAboutController;
use App\Http\Controllers\Admin\AboutUsController;



// ⬇ Default Landing Page
Route::get('/', function () {
    return view('welcome');
});

// ⬇ Custom Auth Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ⬇ Redirect after login based on role
Route::get('/redirect', function () {
    $role = Auth::user()->role ?? null;
    if ($role === 'admin') return redirect()->route('admin.dashboard');
    if ($role === 'user') return redirect()->route('user.dashboard');
    return redirect('/login');
});

// ⬇ Admin Routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
    Route::resource('produk', ProdukController::class);
    Route::resource('kategori', KategoriController::class);

    // Admin Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    // Admin Transactions
    Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions/konfirmasi/{id}', [AdminTransactionController::class, 'konfirmasi'])->name('transactions.konfirmasi');

    // Rute untuk menampilkan form edit
    Route::get('/about-us', [AboutUsController::class, 'edit'])->name('about.edit');

    // Rute untuk menyimpan (update) data
    Route::put('/about-us', [AboutUsController::class, 'update'])->name('about.update');

});

// ⬇ User Routes
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/about-us', [UserAboutController::class, 'index'])->name('about');
    Route::get('/product/{id}', [UserDashboardController::class, 'showProduct'])->name('product.show');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::put('/cart/increase/{id}', [CartController::class, 'increase'])->name('cart.increase');
    Route::put('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');

    // Checkout & Transactions
    Route::get('/checkout', [TransactionController::class, 'checkoutForm'])->name('checkout.form');
    Route::post('/checkout', [TransactionController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
    Route::post('/transactions/selesai/{id}', [TransactionController::class, 'terimaPesanan'])->name('transactions.selesai');
    Route::get('/struk/{id}', [PDFController::class, 'cetakStruk'])->name('struk');

    // Chat ke Admin
 
});

// ⬇ Fallback Chat Routes (jika tidak pakai prefix)
Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('user.chat');
    Route::post('/chat', [ChatController::class, 'store'])->name('user.chat.store');
    Route::get('/admin/chat', [ChatController::class, 'index'])->name('admin.chat');
    Route::post('/admin/chat', [ChatController::class, 'store'])->name('admin.chat.store');

    Route::get('/chat/unread-count', [ChatController::class, 'getUnreadCount'])->name('chat.unreadCount');
});

// ⬇ Optional: Cart routes outside user prefix (redundan, bisa dihapus jika sudah di atas)
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');


