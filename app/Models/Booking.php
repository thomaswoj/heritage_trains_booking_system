<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{

    /**
     * @var string
     */
    protected $table = 'bookings';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function journey()
    {
        return $this->belongsTo(Journey::class);
    }

    /**
     * @param Journey $journey
     * @param $passenger_name
     * @param string $type
     * @return mixed
     */
    public static function createBooking(Journey $journey, $passenger_name, $type = 'outbound')
    {
        $booking = self::create([
            'passenger_name' => $passenger_name,
            'journey_id' => $journey->id,
            'type' => $type,
            'departure_date' => Carbon::now()->format('Y-m-d'),
            'departure_time' => $journey->departure_time,
            'arrival_date' => Carbon::now()->format('Y-m-d'),
            'arrival_time' => $journey->arrival_time,
            'uuid' => Str::uuid(),
        ]);

        return $booking;
    }

}
