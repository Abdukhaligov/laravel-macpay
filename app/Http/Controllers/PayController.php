<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnotSendRequest;
use App\Models\EnotApi;
use App\Models\EnotTransaction;
use App\Models\PayLinkTemplate;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PayController extends Controller {
  public function index(Request $request) {
    $servers = Server::all();

    $data = [
      "steam_id" => $request->steam_id ?? '',
      "server_id" => $request->server_id ?? 0,
      "amount" => $request->amount ?? ''
    ];

    return view('pay.index', compact(['data', 'servers']));
  }

  public function policyAndPolitics() {
    return view('pay.policy');
  }

  public function sendRequestToEnot(EnotSendRequest $request) {
    $MERCHANT_ID = config('enot.merchant_id');  // ID магазина
    $SECRET_WORD = config('enot.secret_word');  // Секретный ключ
    $ORDER_AMOUNT = $request->amount;               // Сумма заказа
    $PAYMENT_ID = time();                           // ID заказа (мы используем time(), чтобы был всегда уникальный ID)

    $sign = md5($MERCHANT_ID.':'.$ORDER_AMOUNT.':'.$SECRET_WORD.':'.$PAYMENT_ID);  //Генерация ключа

    $formData = [
      "m" => $MERCHANT_ID,
      "oa" => $ORDER_AMOUNT,
      "o" => $PAYMENT_ID,
      "s" => $sign,
      "cf" => [
        "steam_id" => $request->steam_d,
        "server_id" => $request->server_d,
      ]
    ];

    EnotApi::create([
      "form" => $request->toArray(), "request" => $formData, "type" => EnotApi::REQUEST
    ]);

    $url = "https://enot.io/pay?".http_build_query($formData);

    return redirect($url);
  }

  public function getResponseFromEnot(Request $request) {
    $merchant = $request->merchant; // id вашего магазина
    $secret_word2 = config('enot.secret_word_2'); // секретный ключ 2

    $sign = md5($merchant.':'.$request->amount.':'.$secret_word2.':'.$request->merchant_id);

    EnotApi::create([
      "response" => $request->toArray(),
      "success" => $sign == $request->sign_2,
      "type" => EnotApi::RESPONSE
    ]);

    if ($sign != $request->sign_2) {
      return view('pay.reject');
    }

    EnotTransaction::create([
      "steam_id" => $request->custom_field["steam_id"],
      "server_id" => $request->custom_field["server_id"],
      "amount" => $request->amount,
    ]);

    return view('pay.success');
  }

  public function template($uuid) {
    $template = PayLinkTemplate::where('uuid', $uuid)
      ->where('active', true)
      ->firstOrFail();

    $servers = Server::all();

    $data = [
      "steam_id" => $template->steam_id ?? '',
      "server_id" => $template->server_id ?? 0,
      "amount" => $template->amount ?? ''
    ];

    return view('pay.index', compact(['data', 'servers']));
  }
}