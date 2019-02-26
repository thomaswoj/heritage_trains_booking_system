<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Transformers\Journey\AvailableJourneyTransformer;
use App\Models\Journey;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * @return $this
     */
    public function index()
    {
        return view('frontend.booking.index')->with([
            'available_journeys' => $this->availableJourneys()
        ]);
    }

    /**
     * @return array|string
     */
    public function availableJourneys()
    {
        $available_journeys = [
            'today_outbound' => fractal(Journey::getTodaysOutbound(), new AvailableJourneyTransformer)->toArray()['data'],
            'today_return'   => fractal(Journey::getTodaysReturn(), new AvailableJourneyTransformer)->toArray()['data']
        ];

        if(request()->wantsJson()) {
            return json_encode($available_journeys);
        }

        return $available_journeys;
    }
}
