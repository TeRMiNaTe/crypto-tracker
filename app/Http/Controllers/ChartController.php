<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

use App\Models\Ticker;
use Database\Factories\TickerFactory;

class ChartController extends Controller
{
	/**
	 * Display the ticker data for a support ticker
	 */
	public function show(Request $request): Response
	{
		$request->merge([
			'symbol' => strtoupper($request->symbol),
		])->validate([
			'symbol' => [
				'required',
				Rule::in(TickerFactory::TICKERS),
			],
		]);

		$data = Ticker::where('symbol', $request->symbol)->get()->map(function ($record, $key) {
			$record->updated_at *= 1000;

			return $record;
		});

		return Inertia::render('Chart', [
			'tickerData' => $data,
			'tickerSymbol' => $request->symbol,
		]);
	}
}
