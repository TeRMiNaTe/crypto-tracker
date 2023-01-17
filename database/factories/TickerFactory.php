<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use App\Exceptions\UnsupportedTickerException;
use App\Models\Ticker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticker>
 */
class TickerFactory extends Factory
{
	/**
	 * The list of supported ticker symbols
	 *
	 * @var array
	 */
	public const TICKERS = ['BTCUSD', 'ETHUSD'];

	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition()
	{
		return [
			'symbol' => Arr::random(self::TICKERS),
			'price' => fake()->randomFloat(1),
			'updated_at' => strtotime('now'),
		];
	}

	/**
	 * @inheritDoc
	 *
	 * Performs additional validation for valid ticker symbols
	 */
	public function newModel(array $attributes = []): Ticker
	{
		if (!in_array($attributes['symbol'], self::TICKERS)) {
			throw new UnsupportedTickerException('Unsupported Ticker');
		}

		return parent::newModel($attributes);
	}

	/**
	 * Returns instances of all of the supported tickers
	 *
	 * @return Collection
	 */
	public function newAll(): Collection
	{
		return collect(array_map(fn($symbol) => $this->newModel(['symbol' => $symbol]), self::TICKERS));
	}
}
