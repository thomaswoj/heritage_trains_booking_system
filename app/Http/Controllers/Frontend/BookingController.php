<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Transformers\Booking\Journey\TicketTransformer;
use App\Http\Transformers\Booking\Journey\AvailableJourneyTransformer;
use App\Models\Booking;
use App\Models\Journey;
use Illuminate\Http\Request;
use PDF;

class BookingController extends Controller
{

    /**
     * @var bool
     */
    protected $booking_validation_passed = true;

    /**
     * @var string
     */
    protected $booking_validation_msg = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Frontend Booking Page
     * ---------------------
     *
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

    /**
     * @param $request
     */
    public function validateBookingRequest($request) {

        $data = $request['passengerData'];

        if(!isset($data)) {
            $this->booking_validation_passed = false;
            $this->booking_validation_msg .= 'Passenger data missing. ';
        }

        if(!isset($data['passenger_count']) || $data['passenger_count'] == null) {
            $this->booking_validation_passed = false;
            $this->booking_validation_msg .= 'Passenger count missing. ';
        }

        if(!isset($data['selected_outbound']) || $data['selected_outbound']['id'] == null) {
            $this->booking_validation_passed = false;
            $this->booking_validation_msg .= 'Outbound journey ID missing. ';
        }

        if(!isset($data['selected_return']) || $data['selected_return']['id'] == null) {
            $this->booking_validation_passed = false;
            $this->booking_validation_msg .= 'Return journey ID missing. ';
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {

        $this->validateBookingRequest($request);
        if(!$this->booking_validation_passed) {
            return response()->json(['status' => 'error', 'msg' => $this->booking_validation_msg]);
        }

        $data = $request['passengerData'];
        $created_booking_ids = [];

        // Store the bookings for each passenger!
        for ($i = 1; $i <= $data['passenger_count']; $i++) {
            $passenger_name = $data['passenger_names'][$i];
            $outbound = Journey::find($data['selected_outbound']['id']);
            $return = Journey::find($data['selected_return']['id']);

            $created_booking_ids[] = Booking::createBooking($outbound, $passenger_name, 'outbound')->id;
            $created_booking_ids[] = Booking::createBooking($return, $passenger_name, 'return')->id;
        }

        $download_string = '';
        foreach($created_booking_ids as $id) {
            $download_string .= 'booking_ids[]='.$id.'&';
        }

        return response()->json(['status' => 'success', 'download_string' => $download_string]);
    }

    /**
     * Download a single PDF of tickets from an array of booking_ids
     * -------------------------------------------------------------
     *
     * @param Request $request
     * @return mixed
     */
    public function downloadTickets(Request $request) {

        if(!is_array($request['booking_ids']) || empty($request['booking_ids'])) {
            abort(404);
        }

        $booking_ids = $request['booking_ids'];

        // Create a collection of bookings from the given booking_ids
        $tickets = collect($booking_ids)->map(function($booking_id) {
            $booking = Booking::with(['journey'])->findOrFail($booking_id);
            return fractal($booking, new TicketTransformer)->toArray()['data'];
        });

        // Generate and download PDF
        $pdf = PDF::loadView('pdf.ticket', ['tickets' => $tickets])->setPaper('a6', 'landscape');
        $pdf_name = 'heritage_train_line_tickets_'.$tickets[0]['journey_date'].'.pdf';
        return $pdf->download($pdf_name);
    }
}
