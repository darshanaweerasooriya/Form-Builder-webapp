<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;

Route::get('/forms', [FormController::class, 'index']);
Route::post('/forms', [FormController::class, 'store']);
Route::get('/forms/{id}', [FormController::class, 'show']);
Route::put('/forms/{id}', [FormController::class, 'update']);
Route::delete('/forms/{id}', [FormController::class, 'destroy']);
Route::get('/csrf-token', function () {
    return response()->json(['token' => csrf_token()]);
});

