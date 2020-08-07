<?php

use Illuminate\Database\Seeder;
use App\Location;

class locationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Insert locations into the database
     *
     * @return void
     */
    public function run()
    {
        // The higher the RNG seed, the more likely the location is to be generated in random generation.
        Location::create(['name' => 'Dublin',     'rng_seed' => 95, 'is_main_hq' => true]);
        Location::create(['name' => 'Bratislava', 'rng_seed' => 5]);
        Location::create(['name' => 'Berlin',     'rng_seed' => 20]);
        Location::create(['name' => 'Paris',      'rng_seed' => 28]);
        Location::create(['name' => 'Hong Kong',  'rng_seed' => 31]);
        Location::create(['name' => 'Sydney',     'rng_seed' => 31]);
        Location::create(['name' => 'New York',   'rng_seed' => 46]);
    }
}
