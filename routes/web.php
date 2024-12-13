<?php

namespace App\Http\Controllers;
//use App\Http\Controllers\Admin;


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
//use App\Http\Controllers\Admin\MenuController;
//use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\TableController;
//use App\Http\Controllers\Admin\ReservationController;
use Illuminate\Support\Facades\Route;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Tableau de bord de l'utilisateur
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



//Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
  //  Route::resource('categories', CategoryController::class);
   // Route::resource('tables', TableController::class);

//});

// Ajoutez cette route si elle n'existe pas
//Route::get('/admin', function () {
  //  return view('admin.index');
//})->name('admin.index');

// Routes pour l'admin, protégées par les middlewares "auth" et "admin"
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('tables', TableController::class);
    Route::get('/', function () {
        return view('admin.index');
    })->name('admin.index');
});

// Routes protégées par le middleware "auth"
Route::middleware('auth')->group(function () {
    // Formulaire de recherche
    Route::get('/client/search', [ClientSearchController::class, 'showSearchForm'])->name('client.search');

    // Résultats de recherche
    Route::post('/client/search/results', [ClientSearchController::class, 'searchTables'])->name('client.search.results');
});

// Réservation
Route::get('/client/reservation/{tableId}', [ReservationController::class, 'showReservationForm'])
    ->middleware('auth')
    ->name('client.reservation.form');
Route::post('/client/reservation/{tableId}', [ReservationController::class, 'submitReservation'])
    ->middleware('auth')
    ->name('client.reservation.submit');

// Paiement
Route::get('/client/payment/{reservationId}', [PaymentController::class, 'showPaymentForm'])
    ->middleware('auth')
    ->name('client.payment.form');
Route::post('/client/payment/{reservationId}', [PaymentController::class, 'submitPayment'])
    ->middleware('auth')
    ->name('client.payment.submit');


Route::post('/client/reservation/store', [ReservationController::class, 'store'])->name('client.reservation.store');
Route::post('/client/payment/store', [PaymentController::class, 'store'])->name('client.payment.store');


// Routes pour les utilisateurs authentifiés
Route::middleware('auth')->group(function () {
    // Gestion du profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Authentification
require __DIR__.'/auth.php';
