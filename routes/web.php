<?php

// use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Models\Item;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController; 



//AUTH
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//HALAMAN UTAMA
Route::get('/', function () {
    return view('app');
})->name('app.home')->middleware('auth');

//SALEEEE
Route::get('/sale', [SaleController::class, 'index'])->name('sale.index'); // Halaman pilih item (index)

Route::post('/sale/checkout', [SaleController::class, 'checkoutProcess'])->name('sale.checkout');  // Proses checkout, simpan data di session
Route::get('/sale/checkout', [SaleController::class, 'showCheckoutPage'])->name('sale.checkout.page');  // Menampilkan halaman checkout dengan data dari session
Route::post('/sale/submit', [SaleController::class, 'submit'])->name('sale.submit');

Route::get('/sale/struk', [SaleController::class, 'generateReceipt'])->name('sale.struk');

Route::get('/sale/payment/success', function () {
    return view('sale.payment_success');
})->name('sale.payment.success');

//RIWAYATTT TRANSAKSIII
Route::get('/transactions', function () {
    return view('transactions.index');
})->name('transactions.index');

// ITEM EDIT
Route::get('/items', [ItemController::class, 'itemsIndex'])->name('items.index');
    //form tambah menu
    Route::get('/create', function () {
        return view('items.create');
    })->name('items.create');

    // Rute untuk menyimpan item
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');

    //form edit
    Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');

    // Update data item
    Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');

    // Delete item
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');


//RIWAYATT TRANSAKSI
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

//EDIT PROFILE
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');