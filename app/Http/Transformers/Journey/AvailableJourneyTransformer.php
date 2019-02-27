<?php namespace App\Http\Transformers\Journey;

use App\Models\Journey;
use Auth;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

/**
 * Class CommentTransformer
 */
class AvailableJourneyTransformer extends TransformerAbstract
{

    /**
     * @param $journey
     * @return array
     */
    public function transform(Journey $journey)
    {
        $time_format = 'H:i';

        $data = [
            'id'             => $journey->id,
            'from_station'   => $journey->fromStation->name,
            'to_station'     => $journey->toStation->name,
            'train'          => $journey->train->name,
            'seats_available'=> $journey->seats_available,
            'departure_time' => Carbon::createFromFormat('H:i:s', $journey->departure_time)->format($time_format),
            'arrival_time'   => Carbon::createFromFormat('H:i:s', $journey->arrival_time)->format($time_format),
            'is_canceled'    => (bool)$journey->is_canceled,
            'journey_date'     => Carbon::now()->format('d/m/Y'),
        ];

        $data['is_available'] = $this->checkIfJourneyAvailable($journey);

        return $data;
    }

    /**
     * @param Journey $journey
     * @return bool
     */
    public function checkIfJourneyAvailable(Journey $journey) {
        if($journey->seats_available < 1) {
            return false;
        }

        if($journey->is_canceled) {
            return false;
        }

        return true;
    }

}