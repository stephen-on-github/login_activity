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

        return View('loginActivity', compact('locations', 'mainHq'));
    }

    // API for fetching login information
    public function loginActivityApi(Request $request)
    {
        $interval = $request['interval'] ?? 60;

        // Get all login data, with the filters applied
        return Login::filter($request)
            ->groupByInterval($interval)
            ->groupByLocation()
            // Format the data to work with Google Charts
            ->getGoogleChartData();
    }
}
