<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class BookingsExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function __construct($full_export = true)
    {
        $this->full_export = $full_export;
    }

    public function headings(): array {
        return [
            'Passenger Name',
            'Journey',
            'From',
            'To',
            'Train',
            'Departure Date',
            'Departure Time',
            'Arrival Date',
            'Arrival Time',
            'Boarded At',
            'Journey UUID',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function query()
    {
        $query = DB::table('bookings')
            ->leftJoin('journeys as journey', 'journey_id', '=', 'journey.id')
            ->leftJoin('vehicles as train', 'journey.vehicle_id', '=', 'train.id')
            ->leftJoin('stations as station_from', 'journey.from_station_id', '=', 'station_from.id')
            ->leftJoin('stations as station_to', 'journey.to_station_id', '=', 'station_to.id')
            ->select([
                'bookings.passenger_name',
                DB::raw('upper(bookings.type)'),
                DB::raw('upper(station_from.name) as station_from'),
                DB::raw('upper(station_to.name) as station_to'),
                DB::raw('upper(train.name) as train_name'),
                'bookings.departure_date',
                'bookings.departure_time',
                'bookings.arrival_date',
                'bookings.arrival_time',
                'bookings.boarded_at',
                'bookings.uuid',
            ])
            ->orderBy('bookings.id');

        return $query;
    }
}
