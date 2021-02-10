<?php

use App\Http\Controllers\ApiController;
use App\Models\EnotTransaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('servers', [ApiController::class, 'serverList']);
Route::get('enot-url', [ApiController::class, 'generateEnotRequest']);
Route::get('enot-response', [ApiController::class, 'getResponseFromEnot']);
Route::get('get-transactions', function (Request $request) {
  $token = 'Jb?c4MBpbKR4DmyaLERU=55yJKk';

  if ($request->token == $token) {
    return response()->json(EnotTransaction::where('id')->orderByDesc('id')->limit(50)->get());
  } else {
    return response()->json(["message" => "unauthorized"], JsonResponse::HTTP_UNAUTHORIZED);
  }
});