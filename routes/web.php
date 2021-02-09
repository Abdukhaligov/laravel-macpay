<?php

use App\Http\Controllers\PayController;
use Illuminate\Support\Facades\Route;

Route::name('pay.')->group(function () {
  Route::get('/', [PayController::class, 'index'])->name('index');
  Route::get('/policy', [PayController::class, 'policyAndPolitics'])->name('policy');
});

