<?php

namespace App\Http\Controllers;

use App\Models\PayLinkTemplate;
use App\Models\Server;
use Illuminate\Http\Request;

class PayController extends Controller {
  public function index(Request $request) {
    $servers = Server::all();

    $data = [
      "steamId" => $request->steamId ?? '',
      "serverId" => $request->serverId ?? 0,
      "amount" => $request->amount ?? ''
    ];

    return view('pay.index', compact(['data', 'servers']));
  }

  public function policyAndPolitics() {
    return view('pay.policy');
  }

  public function check(Request $request){
    dd($request->all());
  }

  public function template ($uuid){
    $template = PayLinkTemplate::where('uuid', $uuid)
      ->where('active', true)
      ->firstOrFail();

    $servers = Server::all();

    $data = [
      "steamId" => $template->steam_id ?? '',
      "serverId" => $template->server_id ?? 0,
      "amount" => $template->amount ?? ''
    ];

    return view('pay.index', compact(['data', 'servers']));
  }
}