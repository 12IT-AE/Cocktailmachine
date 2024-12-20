<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\{
    RecipeController,
    LiquidController,
    PumpController,
    ContainerController,
    IngredientController,
    GlassController,
    GarnishController,
    OrderController,
    OrderPiController
};

Route::get('/', function () {
    return redirect()->route('order.index');
});

Route::group(['prefix' => 'admin'], function () {
    Route::resource('recipe', RecipeController::class);
    Route::resource('liquid', LiquidController::class);
    Route::resource('pump', PumpController::class);
    Route::resource('container', ContainerController::class);
    Route::resource('ingredient', IngredientController::class);
    Route::resource('glass', GlassController::class);
    Route::resource('garnish', GarnishController::class);
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $password = $request->input('password');
    if ($password === env('ADMIN_PASSWORD')) {
        session(['admin' => true]);
        return redirect()->route('recipe.index');
    }
    return redirect()->route('login')->withErrors(['password' => 'Incorrect password']);
})->name('login');

Route::post('/logout', function () {
    session(['admin' => false]);
    return redirect()->route('order.paginatedIndex');
})->name('logout');

Route::group(['prefix' => ''], function() {
    Route::resource('recipe', RecipeController::class);
    Route::resource('liquid', LiquidController::class);
    Route::resource('pump', PumpController::class);
    Route::resource('container', ContainerController::class);
    Route::resource('ingredient', IngredientController::class);
    Route::resource('glass', GlassController::class);
    Route::resource('garnish', GarnishController::class);
    Route::resource("order", OrderController::class);
    Route::get('order/modal/{id}', [OrderController::class, 'modal'])->name('order.modal');
    Route::get('/orders', [OrderController::class, 'paginatedIndex'])->name('order.paginatedIndex');
    Route::get('/orderPi', [OrderController::class, 'orderPi'])->name('order.orderPi');
});

    