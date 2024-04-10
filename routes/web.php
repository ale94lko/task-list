<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\TaskController::class, 'index']);
Route::post('/store', [App\Http\Controllers\TaskController::class, 'store']);

require __DIR__.'/auth.php';
