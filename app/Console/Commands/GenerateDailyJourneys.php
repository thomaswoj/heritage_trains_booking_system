<?php

namespace App\Console\Commands;

use App\Models\Journey;
use App\Models\Station;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateDailyJourneys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'journeys:generate';

    /**
     * @var int
     */
    private $time_between_journeys;
    private $journey_duration;

    /**
     * Default journey timings
     * -----------------------
     * Train Thomas - Station (id 1) to Engine Shed (id 2),
     * Departs on the hour from 10am to 3pm (20 min journey)
     * Returns on the half hour.
     *
     * Train Ivor - Station (id 1) to Engine Shed (id 2),
     * Departs on the hour from 10.30am to 3.30pm (20 min journey)
     * Returns on the hour.
     *
     */

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the journey table with the initial default journey timings.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->time_between_journeys = 30; // Default time between two journeys
        $this->journey_duration = 20; // Used for populating arrival_time column

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::table('journeys')->truncate();

        try {
            // Generate journeys for train Thomas
            $this->generateJourneys('thomas', 'station', 'engine shed', '10:00:00', '15:00:00');

            // Generate journeys for train Ivor
            $this->generateJourneys('ivor', 'station', 'engine shed', '10:30:00', '15:30:00');
        } catch (\Exception $e) {
            $this->error('Unable to create journeys.'.$e->getMessage());
            return false;
        }

        $this->info('Successfully created the journeys table.');
        return true;
    }

    /**
     * Populates the journeys table with initial records
     * -------------------------------------------------
     * Departure timings should be given in the format 'H:i:s'.
     *
     * @param String $vehicle
     * @param String $from
     * @param String $to
     * @param $initial_departure_time
     * @param $last_departure_time
     * @return bool
     */
    public function generateJourneys(String $vehicle, String $from, String $to, $initial_departure_time, $last_departure_time)
    {
        $vehicle = Vehicle::whereName($vehicle)->first();
        $from_station = Station::whereName($from)->first();
        $to_station   = Station::whereName($to)->first();

        $departure = Carbon::createFromFormat('H:i:s', $initial_departure_time);
        $last_departure = Carbon::createFromFormat('H:i:s', $last_departure_time);

        $outbound = true;

        while ($departure->lte($last_departure)) {
            // Set the arrival time
            $arrival_time = Carbon::createFromFormat('H:i:s', $departure->format('H:i:s'))->addMinutes($this->journey_duration);

            // Create the journey record
            $journey = new Journey();
            $journey->create([
                'vehicle_id' => $vehicle->id,
                'departure_time' => $departure->format('H:i:s'),
                'arrival_time' => $arrival_time,
                'from_station_id' => $outbound === true ? $from_station->id : $to_station->id,
                'to_station_id' => $outbound === true ? $to_station->id : $from_station->id
            ]);

            // Flip the outbound flag for return journeys and update departure time
            $outbound = !$outbound;
            $departure = $departure->addMinutes($this->time_between_journeys);
        }

        return true;
    }
}
