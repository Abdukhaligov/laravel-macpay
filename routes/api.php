<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('servers', [ApiController::class, 'serverList']);
Route::get('enot-url', [ApiController::class, 'generateEnotRequest']);
Route::post('enot-response', [ApiController::class, 'getResponseFromEnot']);