<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Transformers\Journey\AvailableJourneyTransformer;
use App\Models\Journey;
use Illuminate\Http\Request;
use PDF;

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

        //TESTING PDF
//        $pdf = PDF::loadView('pdf.ticket', [])->setPaper('a6', 'landscape');
//        return $pdf->download('tickets.pdf');
        
        return view('frontend.booking.index')->with([
            'available_journeys' => $this->availableJourneys()
        ]);
    }

    /**
     * @return array|string
     */
    public function availableJourneys()
    {
        // Journeys available today.
        $outbound = fractal(Journey::getTodaysOutbound(), new AvailableJourneyTransformer)->toArray()['data'];
        $return = fractal(Journey::getTodaysReturn(), new AvailableJourneyTransformer)->toArray()['data'];

        $available_journeys = [
            'today_outbound' => $outbound,
            'today_return'   => $return,
            'outbound_subtitle' => 'From Station to Engine Shed',
            'return_subtitle'   => 'From Engine Shed to Station',
        ];

        if(request()->wantsJson()) {
            return json_encode($available_journeys);
        }

        return $available_journeys;
    }
}
