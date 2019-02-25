<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{

    public const TRAIN_ID = 1;

    /**
     * @var string
     */
    protected $table = 'vehicles';

    /**
     * @var array
     */
    protected $guarded = ['id'];

}
