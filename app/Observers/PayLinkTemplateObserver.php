<?php

namespace App\Observers;

use App\Models\PayLinkTemplate;
use Illuminate\Support\Str;

class PayLinkTemplateObserver {
  public function creating(PayLinkTemplate $model){
    $model->link = Str::uuid();
  }
}
