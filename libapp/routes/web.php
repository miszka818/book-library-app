<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome endpoint',
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->get('/dashboard', function (Request $request) {
    return response()->json([
        'message' => 'Dashboard endpoint',
        'user' => $request->user(),
    ]);
});

Route::get('/dashboard', function () {
    return response()->json(['message' => 'Dashboard']);
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/settings.php';