<?php

use Illuminate\Support\Facades\Route;

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
//Public
Route::get('/', [App\Http\Controllers\PublicController::class, 'index'])->name('home.page');

Auth::routes();

Route::get('/admin/graph/{id}', [App\Http\Controllers\AdminController::class, 'graph_area']);
Route::get('/login', [App\Http\Controllers\CustomAuth::class, 'index'])->name('login');
Route::POST('/validate', [App\Http\Controllers\CustomAuth::class, 'customLogin'])->name('custom.login');
//GET
Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/nasabah', [App\Http\Controllers\NasabahController::class, 'index'])->name('admin.nasabah');
Route::get('/admin/simpanan', [App\Http\Controllers\SimpananController::class, 'index'])->name('admin.simpanan');
Route::get('/admin/simpanan/detail/{id}', [App\Http\Controllers\SimpananController::class, 'detail']);
Route::get('/admin/pinjaman', [App\Http\Controllers\PinjamanController::class, 'index'])->name('admin.pinjaman');
Route::get('/admin/pinjaman/detail/{id}', [App\Http\Controllers\PinjamanController::class, 'detail']);
Route::get('/admin/biaya', [App\Http\Controllers\BiayaController::class, 'index'])->name('admin.biaya');
Route::get('/admin/pembayaran', [App\Http\Controllers\PembayaranController::class, 'index'])->name('admin.pembayaran');
Route::get('/admin/shu', [App\Http\Controllers\SHUController::class, 'index'])->name('admin.shu');
Route::get('/admin/pengaturan', [App\Http\Controllers\SettingController::class, 'index'])->name('admin.pengaturan');

//Cetak
Route::get('/admin/shu/cetak/{awal}/{akhir}', [App\Http\Controllers\SHUController::class, 'cetak']);

//Nasabah GET
Route::get('/nasabah/dashboard', [App\Http\Controllers\LoginNasabah::class, 'index'])->name('nasabah.dashboard');
Route::get('/nasabah/pinjaman', [App\Http\Controllers\LoginNasabah::class, 'pinjaman'])->name('nasabah.pinjaman');
Route::get('/nasabah/pembayaran', [App\Http\Controllers\LoginNasabah::class, 'pembayaran'])->name('nasabah.pembayaran');
Route::get('/nasabah/simpanan', [App\Http\Controllers\LoginNasabah::class, 'simpanan'])->name('nasabah.simpanan');
Route::get('/nasabah/profil', [App\Http\Controllers\LoginNasabah::class, 'profil'])->name('nasabah.profil');

//POST
Route::POST('/admin/nasabah/save', [App\Http\Controllers\NasabahController::class, 'store']);
Route::POST('/admin/simpanan/save', [App\Http\Controllers\SimpananController::class, 'store']);
Route::POST('/admin/pinjaman/save', [App\Http\Controllers\PinjamanController::class, 'store']);
Route::POST('/admin/pinjaman/bayar', [App\Http\Controllers\PinjamanController::class, 'bayar']);
Route::POST('/admin/pembayaran/save', [App\Http\Controllers\PembayaranController::class, 'store']);
Route::POST('/admin/biaya/save', [App\Http\Controllers\BiayaController::class, 'store']);
Route::POST('/nasabah/pinjaman/save', [App\Http\Controllers\LoginNasabah::class, 'store_pinjaman']);

//UPDATE POST
Route::POST('/admin/nasabah/update/{id}', [App\Http\Controllers\NasabahController::class, 'update']);
Route::POST('/admin/simpanan/update/{id}', [App\Http\Controllers\SimpananController::class, 'update']);
Route::POST('/admin/pinjaman/update/{id}', [App\Http\Controllers\PinjamanController::class, 'update']);
Route::POST('/admin/pinjaman/bayar/update/{id}', [App\Http\Controllers\PinjamanController::class, 'update_bayar']);
Route::POST('/admin/biaya/update/{id}', [App\Http\Controllers\BiayaController::class, 'update']);
Route::POST('/admin/pembayaran/update/{id}', [App\Http\Controllers\PembayaranController::class, 'update']);
Route::POST('/admin/pinjaman/validasi/{id}', [App\Http\Controllers\PinjamanController::class, 'validasi']);
Route::POST('/admin/pengaturan/update/{id}', [App\Http\Controllers\SettingController::class, 'update']);
Route::POST('/nasabah/pinjaman/update/{id}', [App\Http\Controllers\LoginNasabah::class, 'update_pinjaman']);
Route::POST('/nasabah/profil/update/{id}', [App\Http\Controllers\LoginNasabah::class, 'update']);

//DESTROY
Route::GET('/admin/nasabah/delete/{id}', [App\Http\Controllers\NasabahController::class, 'destroy']);
Route::GET('/admin/simpanan/delete/{id}/{od}', [App\Http\Controllers\SimpananController::class, 'destroy']);
Route::GET('/admin/pinjaman/delete/{id}/{od}', [App\Http\Controllers\PinjamanController::class, 'destroy']);
Route::GET('/admin/pembayaran/delete/{id}', [App\Http\Controllers\PembayaranController::class, 'destroy']);
Route::GET('/admin/biaya/delete/{id}/{od}', [App\Http\Controllers\BiayaController::class, 'destroy']);

//JSON
Route::get('/admin/nasabah/json', [App\Http\Controllers\NasabahController::class, 'json']);
Route::get('/admin/simpanan/json', [App\Http\Controllers\SimpananController::class, 'json']);
Route::get('/admin/simpanan/detail/json/{id}', [App\Http\Controllers\SimpananController::class, 'json_detail']);
Route::get('/admin/pinjaman/json', [App\Http\Controllers\PinjamanController::class, 'json']);
Route::get('/admin/pinjaman/detail/json/{id}', [App\Http\Controllers\PinjamanController::class, 'json_detail']);
Route::get('/admin/pinjaman/detail/pembayaran/{id}', [App\Http\Controllers\PinjamanController::class, 'json_pembayaran']);
Route::get('/admin/pembayaran/json', [App\Http\Controllers\PembayaranController::class, 'json']);
Route::get('/admin/biaya/json', [App\Http\Controllers\BiayaController::class, 'json']);
Route::get('/admin/pembayaran/validasi/json', [App\Http\Controllers\PembayaranController::class, 'json_pinjaman']);
Route::get('/admin/pengaturan/json', [App\Http\Controllers\SettingController::class, 'json']);
Route::get('/nasabah/pinjaman/json', [App\Http\Controllers\LoginNasabah::class, 'json_pinjaman']);
Route::get('/nasabah/simpanan/json', [App\Http\Controllers\LoginNasabah::class, 'json_simpanan']);
Route::get('/nasabah/pembayaran/json', [App\Http\Controllers\LoginNasabah::class, 'json_pembayaran']);
Route::get('/nasabah/pembayaran/find/{id}', [App\Http\Controllers\LoginNasabah::class, 'find_pembayaran']);

//FIND
Route::get('/admin/nasabah/find/{id}', [App\Http\Controllers\NasabahController::class, 'find']);
Route::get('/admin/simpanan/find/{id}', [App\Http\Controllers\SimpananController::class, 'find']);
Route::get('/admin/pinjaman/find/{id}', [App\Http\Controllers\PinjamanController::class, 'find']);
Route::get('/admin/biaya/find/{id}', [App\Http\Controllers\BiayaController::class, 'find']);
Route::get('/admin/pengaturan/find/{id}', [App\Http\Controllers\SettingController::class, 'find']);
Route::get('/admin/pembayaran/find/{id}', [App\Http\Controllers\PembayaranController::class, 'find']);
Route::get('/nasabah/pinjaman/find/{id}', [App\Http\Controllers\LoginNasabah::class, 'find']);

//ROBOT
Route::get('/filter/pinjaman/json', [App\Http\Controllers\PembayaranController::class, 'pinjaman_aktif']);
Route::get('/input/simpanan/{id}', [App\Http\Controllers\PublicController::class, 'input_simpanan']);
Route::get('/input/simpanan_dua/{id}', [App\Http\Controllers\PublicController::class, 'input_simpanan_2']);
Route::get('/input/pembayaran/{id}/{od}/{start}/{end}/{year}', [App\Http\Controllers\PublicController::class, 'input_pembayaran']);
Route::get('/set/pembayaran/{id}', [App\Http\Controllers\PublicController::class, 'set_pembayaran']);
