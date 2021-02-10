<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServerResourceCollection;
use App\Models\EnotApi;
use App\Models\EnotTransaction;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
      "form" => $request->toArray(), "request" => $formData, "type" => EnotApi::REQUEST, "ip" => $request->ip()
    ]);

    $response["url"] = $url = "https://enot.io/pay?".http_build_query($formData);

    return response()->json($response);
  }

  public function getResponseFromEnot(Request $request) {
    try {
      $response["request"] = $request->toArray();

      $response["transactionOriginal"] = $enotApi = EnotApi::where('type', EnotApi::REQUEST)
        ->where('ip', $request->ip())
        ->orderByDesc('created_at')
        ->get()
        ->first();

      $transactionId = $enotApi->request["o"];

      $formData = [
        "api_key" => config('enot.api_key'),
        "email" => config('enot.email'),
        "oid" => $transactionId,
      ];

      $response["paymentInfo"] = $paymentInfo = (Http::get('https://enot.io/request/payment-info', $formData))->json();

      if (count(EnotTransaction::where('order_id', $transactionId)->get())) {
        return response()->json(["status" => "fail", "message" => "orderId already in DB"]);
      }

      $originalAmount = $response["originalAmount"] = $enotApi->form["amount"] ?? '';
      $paymentAmount = $response["paymentAmount"] = $paymentInfo["amount"] ?? '';
      $orderId = $response["orderId"] = $paymentInfo["merchant_id"] ?? '';

      if ($originalAmount && $paymentAmount && $orderId
        && (integer) $originalAmount == (integer) $paymentAmount) {
        $response["status"] = "success";

        EnotTransaction::create([
          "steam_id" => $paymentInfo["custom_field"]["steam_id"] ?? '',
          "server_id" => $paymentInfo["custom_field"]["server_id"] ?? '',
          "amount" => $paymentAmount,
          "order_id" => $orderId
        ]);
      } else {
        $response["status"] = "fail";
      }

      EnotApi::create([
        "request" => $formData, "type" => EnotApi::RESPONSE, "ip" => $request->ip()
      ]);

      return response()->json($response);
    } catch (\Exception $e) {
      return response()->json(["status" => "fail", "message" => $e->getMessage()]);
    }
  }
}
