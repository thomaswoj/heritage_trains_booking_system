<?php namespace App\Http\Transformers\Booking\Journey;

use App\Models\Booking;
use Auth;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

/**
 * Class CommentTransformer
 */
class TicketTransformer extends TransformerAbstract
{

    /**
     * @param Booking $booking
     * @return array
     */
    public function transform(Booking $booking)
    {
        $time_format = 'H:i';
        $date_format = 'd/m/Y';

        $departure_date = Carbon::createFromFormat('Y-m-d', $booking->departure_date)->format($date_format);
        $departure_time = Carbon::createFromFormat('H:i:s', $booking->departure_time)->format($time_format);
        $arrival_time = Carbon::createFromFormat('H:i:s', $booking->arrival_time)->format($time_format);

        $data = [
            'id' => $booking->id,
            'type' => $booking->type,
            'from_station' => $booking->journey->fromStation->name,
            'to_station' => $booking->journey->toStation->name,
            'departure_time' => $departure_time,
            'arrival_time' => $arrival_time,
            'journey_date' => $departure_date,
            'passenger_name' => $booking->passenger_name,
            'train_name' => $booking->journey->train->name,
            'uuid' => $booking->uuid,
        ];

        return $data;
    }

}