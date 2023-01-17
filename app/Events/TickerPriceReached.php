<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Ticker;

class TickerPriceReached
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	/**
	 * The ticker instance.
	 *
	 * @var \App\Models\Ticker
	 */
	public $ticker;

	/**
	 * Create a new event instance.
	 *
	 * @param  \App\Models\Ticker  $ticker
	 * @return void
	 */
	public function __construct(Ticker $ticker)
	{
		$this->ticker = $ticker;
	}
}
