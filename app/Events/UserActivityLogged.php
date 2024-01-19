<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserActivityLogged
{
    use Dispatchable, SerializesModels;

    public $userId;
    public $activityType;
    public $productId;
    public $purchaseAmount;

    public function __construct($userId, $activityType, $productId, $purchaseAmount)
    {
        $this->userId = $userId;
        $this->activityType = $activityType;
        $this->productId = $productId;
        $this->purchaseAmount = $purchaseAmount;
    }
}
