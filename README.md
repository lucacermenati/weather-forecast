# weather-forecast

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

### Api
The only available endpoint is /temperature. Here is it possible to retrieve temperature prediction for today and a day in the future 10 days.
parameters:
- city, string
- date, string in the format Ymd (20220101)
- scale, string in this range of values ('celsius', 'fahrenheit')


calling /cache/clear is it possible to clear the cache used by the application. It can be useful for testing porpouses.
