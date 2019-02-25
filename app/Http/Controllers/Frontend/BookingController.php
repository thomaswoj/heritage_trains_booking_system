<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $today_outbound = Journey::getTodaysOutbound();
        $today_return   = Journey::getTodaysReturn();

        dd($today_outbound);

        return view('frontend.booking.index')->with([
            'available_journeys' => Journey::all()
        ]);
    }
}
