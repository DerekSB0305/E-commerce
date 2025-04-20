<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrderItemController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Ruta de prueba para verificar las relaciones entre modelos
// (Borrar al finalizar las pruebas para evitar filtrado de datos sensibles)
 use App\Models\Order;

 Route::get('/test', function () {
     $order = Order::with(['user', 'orderItems.product', 'payments'])->first();
     return response()->json($order);
 });
// 

// Acceso a los controladores de tipo Resource
Route::resource('orders', OrderController::class);

Route::resource('order-items', OrderItemController::class);

Route::resource('products', ProductController::class);

Route::resource('categories', CategoryController::class);

Route::resource('product-categories', ProductCategoryController::class);

Route::resource('payments', PaymentController::class);
//

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
