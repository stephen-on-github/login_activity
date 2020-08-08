<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Login extends Model
{
    /**
     * Get the location a login was made from
     * (define many-to-one relationship)
     *
     * @return \App\Location
     */
    public function location()
    {
        return $this->belongsTo('App\Location')->get();
    }

    /**
     * Apply filters to a login query builder
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $args
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $args = [])
    {
        if (!empty($args['location_ids'])) {
            $query->whereIn('location_id', $args['location_ids']);
        }

        if (!empty($args['start_date'])) {
            $query->where('time', '>=', $args['start_date'] . ' 00:00:00');
        }

        if (!empty($args['end_date'])) {
            $query->where('time', '<=', $args['end_date'] . ' 23:59:59');
        }

        return $query;
    }

    /**
     * Group logins by time intervals
     * e.g. if grouping by 15 minutes, all logins between 14:00:00 and 14:14:59 will be grouped together.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $minutes    the duration of the interval
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGroupByInterval($query, $minutes = 60)
    {
        // Force the input to be an integer.
        // Since raw SQL is about to be used, this will prevent SQL injection.
        $minutes = (int) $minutes;
        $seconds = $minutes * 60;

        // Database expression to round the time down to the nearest interval
        $expr = "SUBSTRING(SEC_TO_TIME((TIME_TO_SEC(`time`) DIV ".$seconds.") * " . $seconds . "), 1, 5)";

        return $query
            // Also include the start time of the interval and the counter in the query
            ->addSelect([DB::raw($expr . " AS `interval`"), DB::raw('COUNT(*) AS `total`')])
            // Group by the interval
            ->groupBy(DB::raw($expr));
    }

    /**
     * Group logins by location
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $minutes    the duration of the interval
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGroupByLocation($query)
    {
        return $query
            ->addSelect('location_id')
            ->groupBy('location_id');
    }

    /**
     * Convert the query results into a format usable with Google Charts.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return array - list of locations for the keys and a list of data points for the graph.
     */
    public function scopeToGoogleChartData($query)
    {
        $results = $query->get();

        // Get the locations present in the results.
        $locationIds = array_unique(array_column($results->toArray(), 'location_id'));
        $locations = Location::whereIn('id', $locationIds)->get();

        // Group data by interval.
        $dataByInterval = [];
        foreach ($results as $result) {
            $dataByInterval[$result->interval][$result->location_id] = $result->total;
        }

        // Get the 3D array used for the graph points.
        // First column = time interval.
        // Each subsequent column contains the total for a location, in the same order as the locations array
        $rows = [];
        foreach ($dataByInterval as $interval => $intervalData) {
            $row = [$interval];

            foreach ($locations as $column => $location) {
                $row[$column + 1] = isset($intervalData[$location->id]) ? $intervalData[$location->id] : 0;
            }

            $rows[] = $row;
        }

        return [
            'keys' => array_column($locations->toArray(), 'name'),
            'rows' => $rows
        ];
    }
}
