<?php

use App\Http\Controllers\SourateController;
use App\Http\Controllers\VersetController;
use App\Http\Controllers\TraductionController;
use App\Http\Controllers\HadithController;
use App\Http\Controllers\PrecheController;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\ParametreController;
use Illuminate\Support\Facades\Route;


Route::get('/', [SourateController::class, 'index'])->name('sourates.index');
Route::get('/sourates/{id}', [SourateController::class, 'show'])->name('sourates.show');
Route::get('/versets/{id}', [VersetController::class, 'show'])->name('versets.show');
Route::get('/search', [SourateController::class, 'search'])->name('sourates.search');
Route::get('/sourates/{id}/search', [SourateController::class, 'searchVersets'])->name('versets.search');
// Routes pour les Traductions

Route::get('/settings', [ParametreController::class, 'index'])->name('param.index');
Route::post('/erudit', [ParametreController::class, 'storeErudit'])->name('erudit.store');


// Sauvegarde des modifications
Route::put('/parametres/erudit/{id}', [ParametreController::class, 'updateErudit'])->name('erudit.update');

Route::get('/traductions', [TraductionController::class, 'index'])->name('traductions.index');


Route::get('/traductions/versets/select', [TraductionController::class, 'versetSelects'])->name('traductions.versets.select');
Route::post('/traductions/store-versets', [TraductionController::class, 'storeVersets'])->name('traductions.storeVersets');

Route::post('/traductions', [TraductionController::class, 'store'])->name('traductions.store');

// Routes pour les Hadiths du jour
Route::get('/hadiths', [HadithController::class, 'index'])->name('hadiths.index');
Route::get('/hadiths/{id}', [HadithController::class, 'show'])->name('hadiths.show');

//  Routes pour les Prêches (audio & vidéo)
Route::get('/preches', [PrecheController::class, 'index'])->name('preches.index');
Route::get('/preches/{id}', [PrecheController::class, 'show'])->name('preches.show');

//  Routes pour les Cours (audio & vidéo)
Route::get('/cours', [CoursController::class, 'index'])->name('cours.index');
Route::get('/cours/{id}', [CoursController::class, 'show'])->name('cours.show');
