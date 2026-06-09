<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// We will create these controllers later
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PoleController;
use App\Http\Controllers\Admin\FiliereController;
use App\Http\Controllers\Admin\GroupeController;
use App\Http\Controllers\Admin\FormateurController;
use App\Http\Controllers\Admin\StagiaireController;
use App\Http\Controllers\Admin\SeanceController as AdminSeanceController;
use App\Http\Controllers\Admin\AdminExportController;

use App\Http\Controllers\GS\GSDashboardController;
use App\Http\Controllers\GS\GSExportController;

use App\Http\Controllers\Formateur\FormateurDashboardController;
use App\Http\Controllers\Formateur\SeanceController;
use App\Http\Controllers\Formateur\PresenceController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('poles', PoleController::class);
    Route::resource('filieres', FiliereController::class);
    Route::resource('groupes', GroupeController::class);
    Route::resource('formateurs', FormateurController::class);
    Route::resource('stagiaires', StagiaireController::class);
    Route::resource('seances', AdminSeanceController::class);
    Route::get('/exports', [AdminExportController::class, 'index'])->name('exports.index');
    Route::post('/exports/generate', [AdminExportController::class, 'generate'])->name('exports.generate');
});

// GS routes
Route::middleware(['auth', 'role:gs', 'check_pole'])->prefix('gs')->name('gs.')->group(function () {
    Route::get('/dashboard', [GSDashboardController::class, 'index'])->name('dashboard');
    Route::get('/groupes', [GSDashboardController::class, 'groupes'])->name('groupes');
    Route::get('/stagiaires', [GSDashboardController::class, 'stagiaires'])->name('stagiaires');
    Route::get('/stagiaires/{stagiaire}', [GSDashboardController::class, 'show'])->name('stagiaires.show');
    Route::get('/statistiques', [GSDashboardController::class, 'statistiques'])->name('statistiques');
    Route::get('/exports', [GSExportController::class, 'index'])->name('exports.index');
    Route::post('/exports/generate', [GSExportController::class, 'generate'])->name('exports.generate');
    Route::get('/alerts', [GSDashboardController::class, 'alerts'])->name('alerts');
});

// Formateur routes
Route::middleware(['auth', 'role:formateur'])->prefix('formateur')->name('formateur.')->group(function () {
    Route::get('/dashboard', [FormateurDashboardController::class, 'index'])->name('dashboard');
    Route::resource('seances', SeanceController::class);
    Route::get('/seances/{seance}/presences', [PresenceController::class, 'create'])->name('presences.create');
    Route::post('/seances/{seance}/presences', [PresenceController::class, 'store'])->name('presences.store');
    Route::put('/seances/{seance}/presences', [PresenceController::class, 'update'])->name('presences.update');
    Route::post('/seances/{seance}/validate', [PresenceController::class, 'validateAbsences'])->name('presences.validate');
    Route::get('/historique', [FormateurDashboardController::class, 'historique'])->name('historique');
});

require __DIR__.'/auth.php';
