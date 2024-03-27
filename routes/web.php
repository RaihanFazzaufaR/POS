<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\POSController;
use Monolog\Level;

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
//     return view('welcome');
// });

//Pertemuan 2
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('category')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('category');
    Route::get('/food-beverage', [ProductController::class, 'foodBeverage'])->name('foodbev');
    Route::get('/beauty-health', [ProductController::class, 'beautyHealth'])->name('beahea');
    Route::get('/home-care', [ProductController::class, 'homeCare'])->name('hoca');
    Route::get('/baby-kid', [ProductController::class, 'babyKid'])->name('baki');
});

// Route::get('/user/{id}/name/{name}', [UserController::class, 'index'])->name('user');

Route::get('/sales', [SalesController::class, 'index'])->name('sales');

//Pertemuan 3
Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/user', [UserController::class, 'index'])->name('/user');

//Pertemuan 4
Route::get('/user/tambah', [UserController::class, 'tambah'])->name('/user/tambah');
Route::get('/user/ubah/{id}', [UserController::class, 'ubah'])->name('/user/ubah');
Route::get('/user/hapus/{id}', [UserController::class, 'hapus'])->name('/user/hapus');

Route::post('/user/tambah_simpan',[UserController::class, 'tambah_simpan'])->name('/user/tambah_simpan');
Route::put('/user/ubah_simpan/{id}',[UserController::class, 'ubah_simpan'])->name('/user/ubah_simpan');

Route::get('/kategori/create', [KategoriController::class, 'create']);
Route::post('/kategori', [KategoriController::class, 'store']);

Route::get('kategori/edit/{id}', [KategoriController::class, 'edit'])->name('kategoriEdit');
Route::put('kategori/update/{id}', [KategoriController::class, 'update'])->name('kategoriUpdate');

Route::get('kategori/delete/{id}', [KategoriController::class, 'destroy'])->name('kategoriDelete');

Route::resource('m_user', POSController::class);