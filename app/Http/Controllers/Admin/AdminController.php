<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BookingsExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Admin Index
     * -----------
     *
     * @return $this
     */
    public function index()
    {
        return view('admin.index')->with([

        ]);
    }

    public function report()
    {
        $csv_filename = 'full_bookings_report.csv';
        return (new BookingsExport(true))->download($csv_filename);
    }

}
