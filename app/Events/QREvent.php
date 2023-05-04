<?php

namespace App\Events;

use App\Models\Invoice;
use BeyondCode\LaravelWebSockets\WebSockets\Channels\PresenceChannel;
use BeyondCode\LaravelWebSockets\WebSockets\Channels\PrivateChannel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QREvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $data;
    private string $uuid;

    public function __construct($data, string $uuid)
    {
        $this->data = $data;
        $this->uuid = $uuid;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('qr_code_retribution.' . $this->uuid);
    }

    public function broadcastWith()
    {
        $invoice = Invoice::select("id", "category_id")->whereIn('id', $this->data)->get();
        return [
            'data' => '$invoice',
            'uuid' => $this->uuid
        ];
    }
}
