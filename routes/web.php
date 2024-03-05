<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KategoriController;
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

Route::get('/user/{id}/name/{name}', [UserController::class, 'index'])->name('user');

Route::get('/sales', [SalesController::class, 'index'])->name('sales');

//Pertemuan 3
Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);