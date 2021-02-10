<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;

class EnotTransaction extends Resource {
  public static $model = \App\Models\EnotTransaction::class;
  public static $title = 'id';
  public static $search = [
    'id',
  ];

  public function fields(Request $request) {
    return [
      ID::make(__('ID'), 'id')->sortable(),

      Number::make('Amount')->sortable(),

      Text::make('Steam ID', 'steam_id')->sortable(),

      Text::make('Order id', 'order_id')->sortable(),

      Text::make('Server id', 'server_id')->sortable(),
    ];
  }
}
