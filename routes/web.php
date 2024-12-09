<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MagazineController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\RegulationController;
use App\Http\Controllers\ReversionController;
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
Route::post('/daftar-keanggotaan', [LandingPageController::class, 'storeMembers'])->name('members.store');
Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::get('/pencarian/buku', [LandingPageController::class, 'searchBook'])->name('search.book');
Route::get('/pencarian/majalah', [LandingPageController::class, 'searchMagazine'])->name('search.magazine');
Route::get('/pencarian/peraturan', [LandingPageController::class, 'searchRegulation'])->name('search.regulation');
Route::get('/pencarian', [LandingPageController::class, 'search'])->name('search');
Route::get('/daftar-kunjungan', [LandingPageController::class, 'visitors'])->name('visitors');
Route::get('/daftar-keanggotaan', [LandingPageController::class, 'members'])->name('members');
Route::get('/verifikasi/{token}', [LandingPageController::class, 'verify'])->name('verification');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('login');

Route::get('/reminder', [DashboardController::class, 'remind'])->name('remind');

Route::group(['middleware' => ['auth']], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::delete('/peraturan/{id?}', [RegulationController::class, 'destroy'])->name('admin.regulation.delete');
        Route::patch('/peraturan/{id}', [RegulationController::class, 'update'])->name('admin.regulation.update');
        Route::post('/peraturan', [RegulationController::class, 'store'])->name('admin.regulation.store');
        Route::get('/peraturan/{id}/ubah', [RegulationController::class, 'edit'])->name('admin.regulation.edit');
        Route::get('/peraturan/{id}/lihat', [RegulationController::class, 'show'])->name('admin.regulation.show');
        Route::get('/peraturan/tambah', [RegulationController::class, 'create'])->name('admin.regulation.create');
        Route::get('/peraturan/export', [RegulationController::class, 'export'])->name('admin.regulation.export');
        Route::get('/peraturan', [RegulationController::class, 'index'])->name('admin.regulation');

        Route::delete('/majalah/{id?}', [MagazineController::class, 'destroy'])->name('admin.magazine.delete');
        Route::patch('/majalah/{id}', [MagazineController::class, 'update'])->name('admin.magazine.update');
        Route::post('/majalah', [MagazineController::class, 'store'])->name('admin.magazine.store');
        Route::get('/majalah/{id}/ubah', [MagazineController::class, 'edit'])->name('admin.magazine.edit');
        Route::get('/majalah/{id}/lihat', [MagazineController::class, 'show'])->name('admin.magazine.show');
        Route::get('/majalah/tambah', [MagazineController::class, 'create'])->name('admin.magazine.create');
        Route::get('/majalah/export', [MagazineController::class, 'export'])->name('admin.magazine.export');
        Route::get('/majalah', [MagazineController::class, 'index'])->name('admin.magazine');

        Route::delete('/buku/{id?}', [BookController::class, 'destroy'])->name('admin.book.delete');
        Route::patch('/buku/{id}', [BookController::class, 'update'])->name('admin.book.update');
        Route::post('/buku', [BookController::class, 'store'])->name('admin.book.store');
        Route::get('/buku/{id}/ubah', [BookController::class, 'edit'])->name('admin.book.edit');
        Route::get('/buku/{id}/lihat', [BookController::class, 'show'])->name('admin.book.show');
        Route::get('/buku/tambah', [BookController::class, 'create'])->name('admin.book.create');
        Route::get('/buku/export', [BookController::class, 'export'])->name('admin.book.export');
        Route::get('/buku', [BookController::class, 'index'])->name('admin.book');

        Route::delete('/peminjaman-buku/delete/{id?}', [LoanController::class, 'destroy'])->name('admin.loan.delete');
        Route::post('/peminjaman-buku', [LoanController::class, 'store'])->name('admin.loan.store');
        Route::get('/peminjaman-buku/tambah', [LoanController::class, 'create'])->name('admin.loan.create');
        Route::get('/peminjaman-buku', [LoanController::class, 'index'])->name('admin.loan');
        
        Route::delete('/pengembalian-buku/delete/{id?}', [ReversionController::class, 'destroy'])->name('admin.reversion.delete');
        Route::post('/pengembalian-buku', [ReversionController::class, 'store'])->name('admin.reversion.store');
        Route::get('/pengembalian-buku/tambah', [ReversionController::class, 'create'])->name('admin.reversion.create');
        Route::get('/pengembalian-buku', [ReversionController::class, 'index'])->name('admin.reversion');
        
        Route::delete('/daftar-kunjungan/{id?}', [VisitorController::class, 'destroy'])->name('admin.visitor.delete');
        Route::get('/daftar-kunjungan', [VisitorController::class, 'index'])->name('admin.visitor');
    
        Route::delete('/anggota/{id?}', [MemberController::class, 'destroy'])->name('admin.member.delete');
        Route::patch('/anggota/{id}', [MemberController::class, 'update'])->name('admin.member.update');
        Route::post('/anggota', [MemberController::class, 'store'])->name('admin.member.store');
        Route::get('/anggota/{id}/ubah', [MemberController::class, 'edit'])->name('admin.member.edit');
        Route::get('/anggota/tambah', [MemberController::class, 'create'])->name('admin.member.create');
        Route::get('/anggota', [MemberController::class, 'index'])->name('admin.member');
    });
});