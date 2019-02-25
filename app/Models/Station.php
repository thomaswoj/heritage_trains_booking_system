<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{

    /**
     * @var string
     */
    protected $table = 'stations';

    /**
     * @var array
     */
    protected $guarded = ['id'];

}
