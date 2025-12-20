<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class NewNotification implements ShouldBroadcast
{
    use SerializesModels;

    public $user_id;
    public $product_name;

    public function __construct(array $data)
    {
        $this->product_name = $data['product_name'];
        $this->user_id = $data['user_id'];
    }

   public function broadcastOn()
{
    return new Channel('new-notification');
}

    public function broadcastAs()
    {
        return 'new.notification';
    }

    public function broadcastWith()
    {
        return [
            'product_name' => $this->product_name,
            'user_id' => $this->user_id,
            'time' => now()->format('H:i'),
            'date' => now()->format('Y-m-d'),
            'path' => '/vendor/orders',
        ];
    }
}

// namespace App\Events;

// use App\Models\Notification;
// use Illuminate\Broadcasting\Channel;
// use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
// use Illuminate\Queue\SerializesModels;

// class NewNotification implements ShouldBroadcast
// {
//     use SerializesModels;

//     public Notification $notification;

//     public function __construct(Notification $notification)
//     {
//         $this->notification = $notification;
//     }

//     public function broadcastOn()
//     {
//         return new Channel('notifications.' . $this->notification->user_id);
//     }

//     public function broadcastWith()
//     {
//         return [
//             'title'   => $this->notification->title,
//             'message' => $this->notification->message,
//             'url'     => $this->notification->url,
//             'time'    => $this->notification->created_at->diffForHumans(),
//         ];
//     }
// }
