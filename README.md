# Development Process

## Key Points

- Laravel application
- Met Office API
- On the homepage, show the following details:
    - current weather for Dundee and forecast for next 4 days
    - the last time the weather widget was updated
    - For each day include the following information:
        - Weather type (description, symbol)
        - Temperature (high in centigrade)
        - Temperature (low in centigrade)
        - Precipitation chance (%)
        - Wind speed (Mph)
- Cache requests - don't want to call the API each time the page loads
- Create an artisan command to update the widget



## Process

Firstly, I ran the artisan command to get a laravel project setup `composer create-project laravel/laravel huddled-singleton`

While this command was running, I registered for the API. Unfortunately, the first link provided led to a 'Registration Failed' page which I couldn't do anything with, so I disregarded the this and the next 2 links and did a google search for "met office api", which brought me to [this](https://www.metoffice.gov.uk/services/data) page with a list of the APIs. I identified the most relevant API, the Met Office Weather DataHub which provides site-specific forecast data.

I completed the following steps to get set up with the service:

1. Created an account
2. Created a new application `singleton-huddled`
3. Subscribed to the Basic (free) plan that allows for 360 requests each to the hourly, three-hourly, and daily endpoints

API details:

- Client Secret: ...
- Client ID: ...



As per the API documentation, I found the latitude and longitude of Dundee using https://latlong.net. The coordinates came back as 56.462017 and -2.970721 respectively.



weather icons used: https://packagist.org/packages/codeat3/blade-weather-icons

## Setup
1. `composer install`
2. `cp .env.example .env`
3. `php artisan key:generate`
4. `php artisan serve`
5. `php artisan weather:update` (clear cached data and call API, requires page refresh after running)
