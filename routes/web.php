<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MagazineController;
use App\Http\Controllers\RegulationController;
use App\Http\Controllers\VisitorController;

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

Route::post('/daftar-kunjungan', [LandingPageController::class, 'storeVisitors'])->name('visitors.store');
Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::get('/pencarian/buku', [LandingPageController::class, 'searchBook'])->name('search.book');
Route::get('/pencarian/majalah', [LandingPageController::class, 'searchMagazine'])->name('search.magazine');
Route::get('/pencarian/peraturan', [LandingPageController::class, 'searchRegulation'])->name('search.regulation');
Route::get('/pencarian', [LandingPageController::class, 'search'])->name('search');
Route::get('/daftar-kunjungan', [LandingPageController::class, 'visitors'])->name('visitors');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('login');

Route::group(['middleware' => ['auth']], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::delete('/peraturan/{id}', [RegulationController::class, 'destroy'])->name('admin.regulation.delete');
        Route::patch('/peraturan/{id}', [RegulationController::class, 'update'])->name('admin.regulation.update');
        Route::post('/peraturan', [RegulationController::class, 'store'])->name('admin.regulation.store');
        Route::get('/peraturan/{id}/ubah', [RegulationController::class, 'edit'])->name('admin.regulation.edit');
        Route::get('/peraturan/{id}/lihat', [RegulationController::class, 'show'])->name('admin.regulation.show');
        Route::get('/peraturan/tambah', [RegulationController::class, 'create'])->name('admin.regulation.create');
        Route::get('/peraturan/export', [RegulationController::class, 'export'])->name('admin.regulation.export');
        Route::get('/peraturan', [RegulationController::class, 'index'])->name('admin.regulation');

        Route::delete('/majalah/{id}', [MagazineController::class, 'destroy'])->name('admin.magazine.delete');
        Route::patch('/majalah/{id}', [MagazineController::class, 'update'])->name('admin.magazine.update');
        Route::post('/majalah', [MagazineController::class, 'store'])->name('admin.magazine.store');
        Route::get('/majalah/{id}/ubah', [MagazineController::class, 'edit'])->name('admin.magazine.edit');
        Route::get('/majalah/{id}/lihat', [MagazineController::class, 'show'])->name('admin.magazine.show');
        Route::get('/majalah/tambah', [MagazineController::class, 'create'])->name('admin.magazine.create');
        Route::get('/majalah/export', [MagazineController::class, 'export'])->name('admin.magazine.export');
        Route::get('/majalah', [MagazineController::class, 'index'])->name('admin.magazine');

        Route::delete('/buku/{id}', [BookController::class, 'destroy'])->name('admin.book.delete');
        Route::patch('/buku/{id}', [BookController::class, 'update'])->name('admin.book.update');
        Route::post('/buku', [BookController::class, 'store'])->name('admin.book.store');
        Route::get('/buku/{id}/ubah', [BookController::class, 'edit'])->name('admin.book.edit');
        Route::get('/buku/{id}/lihat', [BookController::class, 'show'])->name('admin.book.show');
        Route::get('/buku/tambah', [BookController::class, 'create'])->name('admin.book.create');
        Route::get('/buku/export', [BookController::class, 'export'])->name('admin.book.export');
        Route::get('/buku', [BookController::class, 'index'])->name('admin.book');
        
        Route::delete('/daftar-kunjungan/{id}', [VisitorController::class, 'destroy'])->name('admin.visitor.delete');
        Route::get('/daftar-kunjungan', [VisitorController::class, 'index'])->name('admin.visitor');
    });
});