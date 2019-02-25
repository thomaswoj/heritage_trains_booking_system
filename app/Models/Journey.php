<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journey extends Model
{

    /**
     * @var string
     */
    protected $table = 'journeys';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vehicle()
    {
        return $this->hasOne(Vehicle::class, 'id', 'vehicle_id');
    }

    /**
     * @return Model|null|object|static
     */
    public function train()
    {
        return $this->vehicle()->where('vehicles.type_id', Vehicle::TRAIN_ID);
    }

    /**
     * @param int $from_station_id
     * @param int $to_station_id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getTodaysJourneys($from_station_id = 1, $to_station_id = 2)
    {
        return self::query()
            ->where('from_station_id', $from_station_id)
            ->where('to_station_id', $to_station_id)
            ->orderBy('departure_time')
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getTodaysOutbound()
    {
        return self::getTodaysJourneys(1,2);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getTodaysReturn()
    {
        return self::getTodaysJourneys(2,1);
    }



}
