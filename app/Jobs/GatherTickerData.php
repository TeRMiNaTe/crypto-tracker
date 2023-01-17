<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Events\TickerPriceReached;
use App\Models\Ticker;
use codenixsv\Bitfinex\Clients\BitfinexClient;

class GatherTickerData implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle(BitfinexClient $bitfinex)
	{
		$tickers = Ticker::factory()->newAll()->each(function (Ticker $ticker) use ($bitfinex) {
			$ticker_data = json_decode($bitfinex->getTicker($ticker->symbol));

			$ticker->fill([
				'price'      => $ticker_data->mid,
				'updated_at' => $ticker_data->timestamp,
			])->save();

			event(new TickerPriceReached($ticker));
		});
	}
}
