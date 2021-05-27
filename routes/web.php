<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
Route::get('/', [\App\Http\Controllers\Client\RestaurantsController::class, 'index'])->name('reservationForm');
Route::post('/submit-reservation', [\App\Http\Controllers\Client\ReservationsController::class, 'allowedHours'])->name('allowedHours');
Route::get('/admin', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->group( function () {
    Route::get('/restaurants', function () {
        return Inertia::render('Restaurants/RestaurantIndex');
    })->name('restaurants');

    Route::get('/tables/{restaurant_id}', [\App\Http\Controllers\Admin\TablesController::class, 'index'])->name('tables-index');
//    Route::get('/tables/{restaurant_id}', [\App\Http\Controllers\Admin\TablesController::class, 'show'])->name('tables-show');
    Route::get('/reservations/{restaurant_id}', [\App\Http\Controllers\Admin\ReservationsController::class, 'index'])->name('reservations-index');

    Route::group([
        'prefix' => '/api'
    ], static function () {
        Route::get('/restaurants-index', [\App\Http\Controllers\Admin\RestaurantsController::class, 'index'])->name('get-restaurants-list');
        Route::post('/create-restaurant', [\App\Http\Controllers\Admin\RestaurantsController::class, 'store'])->name('create-restaurant-web');
        Route::post('/create-table', [\App\Http\Controllers\Admin\TablesController::class, 'store'])->name('create-table-web');
    });
});
