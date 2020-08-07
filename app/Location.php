<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * The sum of all `rng_seed` values in the locations table. Used for selecting random locations.
     *
     * @var int
     */
    protected $_rngRange = null;

    /**
     * List of all locations
     *
     * @var \Illuminate\Database\Eloquent\Collection|static[]
     */
    protected $_all = null;


    /**
     * Generate a random location, taking weighting into consideration
     * (Locations with a higher `rng_seed` have a higher chance of being generated.)
     *
     * @return \App\Location
     */
    function getRandom()
    {
        // Set the "all" and "rngRange" members, if not already set.
        if ($this->_all === null) {
            $this->_all = Location::all();
        }

        if ($this->_rngRange === null) {
            // The RNG (random-number generation) range is equal to the sum of all `rng_seed` values in the database.
            // Subtract 1, since counting starts at 0.
            $this->_rngRange = $this->_all->sum('rng_seed') - 1;
        }

        // Generate a random number in the range
        $rand = rand(0, $this->_rngRange);

        // Loop through each location, if the generated number is less than the cumulative sum of the seeds,
        // return the location.
        $sum = 0;
        foreach ($this->_all as $location) {
            $sum += $location->rng_seed;

            if ($rand <= $sum) {
                return $location;
            }
        }

        // Should not reach this line.
        return new Location();
    }
}
