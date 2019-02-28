<?php

namespace App\Models;

use Carbon\Carbon;
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
     * @var array
     */
    protected $appends = ['seats_available'];

    /**
     * @return int
     */
    public function getSeatsAvailableAttribute()
    {
        return $this->train->total_capacity - $this->todaysBookings()->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function todaysBookings()
    {
        $today_date = Carbon::now()->format('Y-m-d');

        return $this->hasMany(Booking::class, 'journey_id', 'id')
            ->whereBetween('created_at', [$today_date.' 00:00:01', $today_date.' 23:59:59']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function fromStation()
    {
        return $this->hasOne(Station::class, 'id', 'from_station_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function toStation()
    {
        return $this->hasOne(Station::class, 'id', 'to_station_id');
    }

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
            ->with(['train', 'fromStation', 'toStation'])
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
