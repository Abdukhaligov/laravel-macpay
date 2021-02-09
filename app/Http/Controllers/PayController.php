<?php

namespace App\Http\Controllers;

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
}