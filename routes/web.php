<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityUpdateController;
use App\Http\Controllers\DailyBoardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('board');
});

Route::middleware('auth')->group(function () {
    Route::get('/board', DailyBoardController::class)->name('board');
    Route::get('/dashboard', DailyBoardController::class)->name('dashboard');

    Route::resource('activities', ActivityController::class)->except(['show']);

    Route::post('/activities/{activity}/updates', [ActivityUpdateController::class, 'store'])
        ->name('activities.updates.store');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
