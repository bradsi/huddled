<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Weather Widget</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
<div class="card">
    <p class="lastUpdated">Last Updated: {{$lastUpdated}}</p>
    <div class="inner-card">
        @foreach($days as $day)
            <div class="day">
                <h1>{{date('D', strtotime($day["time"]))}}</h1>
                <p>{{$day["daySignificantWeatherCode"]}}</p>
                <p>
                    <x-wi-thermometer style="height:30px; width:30px;"/>
                    {{round($day["dayMaxScreenTemperature"])}}{{"\u{2103}"}}
                </p>
                <p>
                    <x-wi-thermometer-exterior style="height:30px; width:30px;"/>
                    {{round($day["nightMinScreenTemperature"])}}{{"\u{2103}"}}
                </p>
                <p>
                    <x-wi-humidity style="height:30px; width:30px;"/>
                    {{$day["dayProbabilityOfRain"]}}%
                </p>
                <p>
                    <x-wi-strong-wind style="height:30px; width:30px;"/>
                    {{round($day["midday10MWindSpeed"])}}mph
                </p>
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
