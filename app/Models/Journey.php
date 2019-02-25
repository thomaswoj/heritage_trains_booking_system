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

}
