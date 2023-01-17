<?php

namespace App\Listeners;

use App\Events\TickerPriceReached;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\PriceAlert;

class SendTickerNotification
{
	/**
	 * Handle the event.
	 *
	 * @param  \App\Events\TickerPriceReached  $event
	 * @return void
	 */
	public function handle(TickerPriceReached $event)
	{
		PriceAlert::where('symbol', $event->ticker->symbol)->where('notified', 0)->each(function (PriceAlert $price_alert) use ($event) {
			if ($event->ticker->price < $price_alert->price_min) {
				return true;
			}

			Mail::raw($event->ticker->symbol.' is now trading above your desired price ('.$price_alert->price_min.') at '.$event->ticker->price, function($message) use ($price_alert) {
				$message->to($price_alert->email);
				$message->from('noreply@cryptotracker.bg');

				// User was notified
				$price_alert->notified = true;
				$price_alert->save();
			});
		});
	}
}
