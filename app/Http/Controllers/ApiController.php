<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServerResourceCollection;
use App\Models\EnotApi;
use App\Models\EnotTransaction;
use App\Models\Server;
use Illuminate\Http\Request;

class ApiController extends Controller {
  public function serverList() {
    return response()->json(new ServerResourceCollection(Server::all()));
  }

  public function generateEnotRequest(Request $request) {
    $response["request"] = $request->toArray();

    $MERCHANT_ID = config('enot.merchant_id');  // ID магазина
    $SECRET_WORD = config('enot.secret_word');  // Секретный ключ
    $ORDER_AMOUNT = $request->amount;               // Сумма заказа
    $PAYMENT_ID = time();                           // ID заказа (мы используем time(), чтобы был всегда уникальный ID)

    $sign = md5($MERCHANT_ID.':'.$ORDER_AMOUNT.':'.$SECRET_WORD.':'.$PAYMENT_ID);  //Генерация ключа

    $response["formData"] = $formData = [
      "m" => $MERCHANT_ID,
      "oa" => $ORDER_AMOUNT,
      "o" => $PAYMENT_ID,
      "s" => $sign,
      "cf" => [
        "steam_id" => $request->steam_id,
        "server_id" => $request->server_id,
      ]
    ];

    EnotApi::create([
      "form" => $request->toArray(), "request" => $formData, "type" => EnotApi::REQUEST
    ]);

    $response["url"] = $url = "https://enot.io/pay?".http_build_query($formData);

    return response()->json($response);
  }

  public function getResponseFromEnot(Request $request) {
    $response["request"] = $request->toArray();

    $merchant = $request->merchant; // id вашего магазина
    $secret_word2 = config('enot.secret_word_2'); // секретный ключ 2

    $sign = md5($merchant.':'.$request->amount.':'.$secret_word2.':'.$request->merchant_id);

    EnotApi::create([
      "response" => $request->toArray(),
      "success" => $sign == $request->sign_2,
      "type" => EnotApi::RESPONSE
    ]);

    if ($sign == $request->sign_2) {
      $response["status"] = "success";

      EnotTransaction::create([
        "steam_id" => $request->custom_field["steam_id"] ?? '',
        "server_id" => $request->custom_field["server_id"] ?? '',
        "amount" => $request->amount ?? '',
      ]);
    } else {
      $response["status"] = "fail";
    }

    return response()->json($response);
  }
}
