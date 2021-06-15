<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class WeatherService
{
    private $curl;
    private $response;
    private $lastUpdated;

    function __construct()
    {
        $this->curl = curl_init();
    }

    public function call() {
        // if data exists in call break out of method, otherwise continue
        if ($this->dataExistsInCache()) return;

        // setup the call to the weather API
        curl_setopt_array($this->curl, [
            CURLOPT_URL => "https://api-metoffice.apiconnect.ibmcloud.com/metoffice/production/v0/forecasts/point/daily?excludeParameterMetadata=true&includeLocationName=true&latitude=56.462017&longitude=-2.970721",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-IBM-Client-Id: 74d570cd-a6b0-4170-bc32-d82cc4e59a77",
                "X-IBM-Client-Secret: cB5hT7fV2qQ0nE4yH1uD1uS3xL6sR4rW7dI6xF7pQ2hI5mN7vY",
                "accept: application/json"
            ],
        ]);

        // execute API call and set response/errors
        $res = curl_exec($this->curl);
        $err = curl_error($this->curl);

        curl_close($this->curl);

        if ($err) {
            abort(400, "cURL Error #:" . $err);
        } else {
            $this->response = $res;
            // cache data returned from API
            Cache::put('weatherData', $this->response);
        }
    }

    public function getResponse() {
        // return data as associative array
        return json_decode($this->response, true);
    }

    public function getLastUpdated() {
        // return the time of the last API call
        return $this->lastUpdated;
    }

    /**
     * Check if API data exists in cache.
     * Returns true if data exists, false otherwise.
     *
     * @returns bool
     */
    private function dataExistsInCache(): bool
    {
        if (Cache::has('lastUpdated')) {
            $this->lastUpdated = Cache::get('lastUpdated');
        } else {
            // set the time of the API call
            $this->lastUpdated = Carbon::now()->toTimeString();
            // cache data returned from API
            Cache::put('lastUpdated', $this->lastUpdated);
        }

        // check if data returned from API has been cached
        if (Cache::has('weatherData')) {
            $this->response = Cache::get('weatherData');
            return true;
        }
        return false;
    }

}
