<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;

Route::get('/forms', [FormController::class, 'index']);
Route::get('/forms/{id}', [FormController::class, 'show']);
Route::post('/forms', [FormController::class, 'store']);
Route::put('/forms/{id}', [FormController::class, 'update']);
Route::delete('/forms/{id}', [FormController::class, 'destroy']);

Route::post('/forms/{id}/submit', [FormController::class, 'submit']);
Route::get('/forms/{id}/submissions', [FormController::class, 'submissions']);
