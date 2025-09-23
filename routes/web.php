<?php

use App\Http\Controllers\ReportController;
use App\Http\Middleware\CeksessionMiddleware;
use App\Livewire\Daftar;
use App\Livewire\Pendaftaran;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "Aplikasi Validasi PIN sedang dalam perbaikan. Terima kasih.";
});
Route::get('/', Pendaftaran::class)->name('pendaftaran');

Route::get('report/{id}', [ReportController::class, 'report']);
Route::get('qrcode/{id}', [ReportController::class, 'qrcode']);
Route::put('savenohp/{nim}', [ReportController::class, 'savenohp']);
// Proses update berkas
Route::post('update-berkas/{nim}', [ReportController::class, 'updateberkas'])->name('user.updateBerkas');

Route::get('9834h29293hd98ehd9dhefieu', function () {
    session([
        'xyz' => 'sadlsajkhdjlahsgdj',
    ]);
    return redirect('daftar');
});
Route::get('logout', function () {
    session([
        'xyz' => '',
    ]);
    return redirect('daftar');
});
Route::get('daftar', Daftar::class)->middleware(CeksessionMiddleware::class);
Route::get('delete/users/{tahun}', function ($tahun) {
    User::whereYear('created_at', $tahun)->delete();
    session()->flash('status', "Semua data Tahun $tahun berhasil dihapus!");
    return redirect('/daftar');
})->middleware(CeksessionMiddleware::class);
