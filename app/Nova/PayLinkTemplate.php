<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class PayLinkTemplate extends Resource {
  public static $model = \App\Models\PayLinkTemplate::class;
  public static $title = 'id';
  public static $search = [
    'id',
  ];

  public function fields(Request $request) {
    return [
      ID::make(__('ID'), 'id')->sortable(),

      Text::make('Steam ID', 'steam_id')
        ->rules(["required"])
        ->sortable(),

      Number::make('Amount',)
        ->rules(["required"])
        ->sortable(),

      BelongsTo::make("Server"),

      Text::make('Uuid')
        ->displayUsing(function () {
          $url = route('pay.template', $this->uuid);

          return "<a target='_blank' href='$url' class='no-underline dim text-primary font-bold'>
                    {$this->uuid}
                  </a>";
        })
        ->asHtml()
        ->hideWhenUpdating()
        ->hideWhenCreating(),

      Boolean::make("Active"),
    ];
  }
}
