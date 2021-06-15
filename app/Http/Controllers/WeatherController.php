<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;

class WeatherController extends Controller {
    public function index(WeatherService $weatherService) {

        $weatherService->call();
        $res = $weatherService->getResponse();

        // API data for next 5 days, including today
        $days = array_slice($res["features"][0]["properties"]["timeSeries"], 1, 5);

        // change significant weather code to readable format
        foreach ($days as &$day) {
            $day["daySignificantWeatherCode"] = $this->parseWeatherCodes($day);
        }

        return view('index', [
            'days' => $days,
            'lastUpdated' => $weatherService->getLastUpdated()
        ]);
    }

    private function parseWeatherCodes(array $arr): string
    {
        $weatherCode = $arr["daySignificantWeatherCode"];

        // reference: https://www.metoffice.gov.uk/services/data/datapoint/code-definitions
        switch ($weatherCode) {
            case 0:
                return 'Clear night';
            case 1:
                return 'Sunny day';
            case 2:
                return 'Partly cloudy (night)';
            case 3:
                return 'Partly cloudy (day)';
            case 5:
                return 'Mist';
            case 6:
                return 'Fog';
            case 7:
                return 'Cloudy';
            case 8:
                return 'Overcast';
            case 9:
                return 'Light rain shower (night)';
            case 10:
                return 'Light rain shower (day)';
            case 11:
                return 'Drizzle';
            case 12:
                return 'Light rain';
            case 13:
                return 'Heavy rain shower (night)';
            case 14:
                return 'Heavy rain shower (day)';
            case 15:
                return 'Heavy rain';
            case 16:
                return 'Sleet shower (night)';
            case 17:
                return 'Sleet shower (day)';
            case 18:
                return 'Sleet';
            case 19:
                return 'Hail shower (night)';
            case 20:
                return 'Hail shower (day)';
            case 21:
                return 'Hail';
            case 22:
                return 'Light snow shower (night)';
            case 23:
                return 'Light snow shower (day)';
            case 24:
                return 'Light snow';
            case 25:
                return 'Heavy snow shower (night)';
            case 26:
                return 'Heavy snow shower (day)';
            case 27:
                return 'Heavy snow';
            case 28:
                return 'Thunder shower (night)';
            case 29:
                return 'Thunder shower (day)';
            case 30:
                return 'Thunder';
            default:
                return "Not available";
        }
    }
}
