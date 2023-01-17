<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\PriceAlert;
use Database\Factories\TickerFactory;

class AlertController extends Controller
{
	/**
	 * Create a price alert for the ticker
	 */
	public function create(Request $request): RedirectResponse
	{
		$request->merge([
			'symbol' => strtoupper($request->symbol),
		])->validate([
			'symbol' => [
				'required',
				Rule::in(TickerFactory::TICKERS),
			],
			'price' => ['required', 'integer', 'numeric'],
			'email' => ['required', 'email'],
		]);

		PriceAlert::updateOrCreate([
			'email' => $request->email,
			'symbol' => $request->symbol,
		], [
			'price_min' => $request->price,
			'notified' => 0,
		]);

		return back()->with('status', 'alert-created');
	}
}
