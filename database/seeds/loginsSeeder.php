<?php

use App\Location;
use App\Login;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class loginsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Run this to add 20,000 random login records. This can be run multiple times.
     *
     * @return void
     */
    public function run()
    {
        $loginData = [];
        $location = new Location();

        // Insert 2000 records at a time. Insert 10 times.
        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 2000; $j++) {
                $loginData[] = [
                    // Won't bias user IDs for now.
                    'user_id' => rand(1, 100),
                    // Random location, biased by the weighting given to each location
                    'location_id' => $location->getRandom()->id,
                    // Random time,
                    // - Biased towards more recent years,
                    // - Dates follow a random distribution around June
                    // - Times follow a random distribution around midday
                    'time' => self::random_date() . ' ' . self::random_time()
                ];
            }

            Login::insert($loginData);
        }
    }

    /**
     * Generate a random date, following a normal distribution around June.
     *
     * @return string    a date in ISO format e.g. '2020-06-15' (15th of June 2020)
     */
    function random_date()
    {
        $year  = self::random_year(2015, 2020);
        $range = date('L', strtotime($year . '01-01')) ? 366 : 365;

        $day = -1;
        while ($day < 0 || $day >= $range) {
            $day = (int) self::stats_rand_gen_normal(178, 100);
        }

        return date($year.'-m-d', strtotime($year . '-01-01 +' . $day.' days'));
    }

    /**
     * Generate a random year in a given range, with bias towards picking more recent years.
     *
     * @return string    a four-digit year e.g. '2020'
     */
    function random_year($min, $max)
    {
        $year = -1;
        while ($year < $min || $year > $max) {
            $year = (int) self::stats_rand_gen_normal($max + 1, 2);
        }

        return $year;
    }

    /**
     * Generate a random time, following a normal distribution around midday.
     *
     * @return string    a time of day in hours, minutes and seconds e.g. '16:30:45'
     */
    function random_time()
    {
        $time = -1;
        while ($time < 0 || $time >= 86400) {
            $time = (int) self::stats_rand_gen_normal(43200, 20000);
        }

        // Add the seconds to midnight of an arbitrary date to convert to a time.
        return date('H:i:s', strtotime('2020-01-01 00:00:00 + ' . $time . ' seconds'));
    }

    /**
     * "Box–Muller transform" based random deviate generator.
     *
     * @ref https://en.wikipedia.org/wiki/Box%E2%80%93Muller_transform
     *
     * @param  float|int $av Average/Mean
     * @param  float|int $sd Standard deviation
     * @return float
     */
    function stats_rand_gen_normal($av, $sd)
    {
        $x = mt_rand() / mt_getrandmax();
        $y = mt_rand() / mt_getrandmax();

        return sqrt(-2 * log($x)) * cos(2 * pi() * $y) * $sd + $av;
    }
}
