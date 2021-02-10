<?php

use App\Http\Controllers\ApiController;
use App\Models\EnotApi;
use App\Models\EnotTransaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('servers', [ApiController::class, 'serverList']);
Route::get('enot-url', [ApiController::class, 'generateEnotRequest']);
Route::get('enot-response', [ApiController::class, 'getResponseFromEnot']);
Route::get('get-transactions', function (Request $request) {
  $token = 'Jb?c4MBpbKR4DmyaLERU=55yJKk';

  if ($request->token == $token) {
    return response()->json(EnotTransaction::orderBy('id', 'DESC')->limit(50)->get());
  } else {
    return response()->json(["message" => "unauthorized"], JsonResponse::HTTP_UNAUTHORIZED);
  }
});
Route::get('sync-transactions', function (Request $request) {
  $token = 'Jb?c4MBpbKR4DmyaLERU=55yJKk';

  if ($request->token == $token) {
    $orderIds = [444545];
    $successOrders = [];
    $response["orders"] = [];

    foreach (EnotApi::where('type', EnotApi::REQUEST)->get() as $value){
      if (!EnotTransaction::where('order_id', $value->request["o"])->get()->first()){
        $orderIds[] = $value->request["o"];
      }
    }

    foreach ($orderIds as $orderId){
      $formData = [
        "api_key" => config('enot.api_key'),
        "email" => config('enot.email'),
        "oid" => $orderId,
      ];

      $response["orders"] [] =[
        "id" => $orderId,
        "info" => (Http::get('https://enot.io/request/payment-info', $formData))->json()
      ];
    }

    foreach ($response["orders"] as $transaction){
      if (isset($transaction["info"]["credited"]) && $transaction["info"]["credited"]){
        $successOrders [] = $transaction;

        EnotTransaction::create([
          "steam_id" => $transaction["info"]["custom_field"]["steam_id"] ?? '',
          "server_id" => $transaction["info"]["custom_field"]["server_id"] ?? '',
          "amount" => $transaction["info"]["amount"],
          "order_id" => $transaction["id"]
        ]);
      }
    }

    $response["successOrders"] = $successOrders;

    return response()->json($response);
  } else {
    return response()->json(["message" => "unauthorized"], JsonResponse::HTTP_UNAUTHORIZED);
  }
});