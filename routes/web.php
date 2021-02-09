<?php

use App\Http\Controllers\PayController;
use Illuminate\Support\Facades\Route;

Route::name('pay.')->group(function () {
  Route::get('/', [PayController::class, 'index'])->name('index');
  Route::post('/check', [PayController::class, 'check'])->name('check');
  Route::get('/policy', [PayController::class, 'policyAndPolitics'])->name('policy');
  Route::get('/template/{uuid}', [PayController::class, 'template'])->name('template');
});

