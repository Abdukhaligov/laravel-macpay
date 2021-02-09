<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Server extends Resource {
  public static $model = \App\Models\Server::class;
  public static $title = 'name';
  public static $search = [
    'id', 'name'
  ];

  public function fields(Request $request) {
    return [
      ID::make(__('ID'), 'id')->sortable(),

      Text::make(__('Name'), 'name')->sortable(),
    ];
  }
}
