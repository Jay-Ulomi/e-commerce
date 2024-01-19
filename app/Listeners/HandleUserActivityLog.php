<?php

namespace App\Listeners;

use App\Events\UserActivityLogged;
use App\Models\UserActivityLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleUserActivityLog
{
    public function handle(UserActivityLogged $event)
    {
        UserActivityLog::create([
            'user_id' => $event->userId,
            'activity_type' => $event->activityType,
            'product_id' => $event->productId,
            'purchase_amount' => $event->purchaseAmount,
        ]);
    }
}
