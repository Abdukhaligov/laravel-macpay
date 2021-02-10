<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('servers', [ApiController::class, 'serverList']);
Route::get('enot-url', [ApiController::class, 'generateEnotRequest']);
Route::get('enot-response', [ApiController::class, 'getResponseFromEnot']);
Route::get('get-transactions', function (Request $request) {
  $token = 'Jb?c4MBpbKR4DmyaLERU=55yJKk';

  if ($request->token == $token) {
    return response()->json(\App\Models\EnotTransaction::all());
  } else {
    return response()->json(["message" => "unauthorized"], JsonResponse::HTTP_UNAUTHORIZED);
  }
});