<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Weather info.",
            "mount" => "weather",
            "handler" => "\Anax\Controller\WeatherController",
        ],
    ]
];
