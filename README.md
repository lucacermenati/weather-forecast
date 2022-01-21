# weather-forecast
The weather forecast application allows you to get temperature predictions for the next 10 days.
The app calculates its own prediction using third party apis (here the results of those api calls are simulated by read the responses from a file). Weather-forecast groups the results from these different api and returns the average temperature as result. It's possible to receive the response in different temperature scales.
The app is developed taking in mind that:
- has to be asy add a new scale
- has to be easy add a new temperature provider/client
- A result returned by an api call has to be considered valid for just 1 minute
- it's possible to return the temperature prediction for today, and the next 10 days.

### Start the application in your local (dev mode)
clone the repository in your local:

```git clone git@github.com:lucacermenati/weather-forecast.git```

move into application folder:

```cd .\weather-forecast\```

run:

```composer install```

start symfony dev server:

```symfony server:start```

the app is available at http://localhost:8000/temperature

### Run tests
```./vendor/bin/phpunit ./tests```

### Api
The only available endpoint is /temperature. Here is it possible to retrieve temperature prediction for today and a day in the future 10 days.
parameters:
- city, string
- date, string in the format Ymd (20221301 = 13 January 2022)
- scale, string in this range of values ('celsius', 'fahrenheit')


calling /cache/clear is it possible to clear the cache used by the application. It can be useful for testing porpouses.
