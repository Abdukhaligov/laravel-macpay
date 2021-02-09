<?php

use App\Http\Controllers\PayController;
use Illuminate\Support\Facades\Route;

Route::name('pay.')->group(function () {
  Route::get('/', [PayController::class, 'index'])->name('index');
  Route::post('/send-request-to-enot', [PayController::class, 'sendRequestToEnot'])->name('sendRequestToEnot');
  Route::post('/get-response-from-enot', [PayController::class, 'getResponseFromEnot'])->name('getResponseFromEnot');
  Route::get('/policy', [PayController::class, 'policyAndPolitics'])->name('policy');
  Route::get('/template/{uuid}', [PayController::class, 'template'])->name('template');
});