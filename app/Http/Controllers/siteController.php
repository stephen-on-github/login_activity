<?php

namespace App\Http\Controllers;

use App\Location;
use App\Login;
use Illuminate\Http\Request;

class siteController extends Controller
{
    // Main view for the application.
    public function loginActivity()
    {
        $locations = Location::where('is_main_hq', 0)->orderBy('name')->get();
        $mainHq    = Location::where('is_main_hq', 1)->orderBy('name')->get();

        // Set the default date range to the current year
        $startDate = date('Y-01-01');
        $endDate   = date('Y-12-31');

        return View('loginActivity', compact('locations', 'mainHq', 'startDate', 'endDate'));
    }

    // API for fetching login information
    public function loginActivityApi(Request $request)
    {
        $interval = $request['interval'] ?? 60;

        // Get all login data, with the filters applied
        return Login::filter($request)
            ->groupByInterval($interval)
            ->groupByLocation()
            ->orderBy('interval')
            // Format the data to work with Google Charts
            ->toGoogleChartData();
    }
}
