<?php

namespace Anax\View;

/**
 * Template file to render a view with content.
 */

// Show incoming variables and view helper functions
// echo showEnvironment(get_defined_vars(), get_defined_functions());

// Prepare incoming variables
$class   = $class ?? null;
$content = $content ?? null;

$url     = $di->get("url");
$request     = $di->get("request");


?><div class="$class">
    <h2>Hämta väderinfo från API</h2>

    <p>Väderapi:et hämtar väderinformation utifrån en koordinat, ett platsnamn eller en ipadress och returnerar ett jsonsobjekt som svar.</p>

    <p>Länken bygger du upp med <code>weather/getJson</code> plus querystring <code>?pos=[POSITION]</code></p>

    <p>Positionsvariabeln kan vara en ipadress, en koordinat eller ett platsnamn i text.</p>

    <p>Svaret innehåller geografisk information om platsen du söker väder på, väderinformation om dagens väder, vädret en vecka framåt samt vädret för 30 föregående dagar.</p>

    <h3>Testa</h3>

    <p>Du kan klicka på länkarna som tar dig till olika testanrop till API:et.</p>

    <ul>
        <li><a href="<?= url("weather/getJson?pos=Stockholm")?>">weather/getJson?pos=Stockholm</a></li>
        <li><a href="<?= url("weather/getJson?pos=59.8585,17.6454")?>">weather/getJson?pos=59.8585,17.6454</a></li>
        <li><a href="<?= url("weather/getJson?pos=83.252.70.69")?>">weather/getJson?pos=83.252.70.69</a></li>
    </ul>

    <h3">API-anrop</h3>

    <h2>Positionsnamn</h2>

    <p>Hämta all väderinformation</p>

    <pre class="code">GET /weather/getjson?pos=Stockholm</pre>

    <p>Results.</p>

    <pre class="code">{
    "errorMsg": "",
    "continent_name": null,
    "country_name": "Sverige",
    "city": "Stockholm",
    "zip": "111 29",
    "latitude": "59.3251172",
    "longitude": "18.0710935",
    "mapUrl": "https://www.openstreetmap.org/#map=12/59.3251172/18.0710935&layers=H",
    "zoomLevel": "12",
    "radius": "600",
    "pos": "Stockholm",
    "positionName": "Stockholm, Sverige",
    "currently": {
        "icon": "clear-night",
        "temperature": -6.28,
        "apparentTemperature": -10.11,
        "summary": "Klart",
        "windSpeed": 2.24,
        "precipProbability": 0,
        "pressure": 1026.45,
        "weekday": "Tisdag",
        "date": "27 november 2018",
        "timeofday": "18:30"
    },
    "hours": {
        "days": {
            "2": {
                "hours": [
                    {
                        "icon": "clear-night",
                        "timeofday": "18:00",
                        "summary": "Klart",
                        "temperature": -6.31,
                        "apparentTemperature": -10.34,
                        "date": "27 november 2018",
                        "weekday": "Tisdag"
                    },
                    ...
                ]
            },
            ...
        }
    },
    "days": [
        {
            "weekday": "Onsdag",
            "date": "28 november 2018",
            "icon": "partly-cloudy-night",
            "summary": "Molnigt som startar under kv\u00e4llen.",
            "temperatureMax": -2.02,
            "apparentTemperatureMax": -6.17,
            "temperatureMin": -8.52,
            "apparentTemperatureMin": -12.43,
            "time": 1543359600
        },
        ...
    ],
    "pastDays": [
        {
            "icon": "clear-day",
            "weekday": "Tisdag",
            "date": "27 november 2018",
            "summary": "Klart under dagen.",
            "temperatureMax": -2.79,
            "apparentTemperatureMax": -7.34,
            "temperatureMin": -7.34,
            "apparentTemperatureMin": -12.12,
            "time": 1543273200
        },
        ...
    ]
}
</div>
