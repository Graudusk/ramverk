<?php
/**
 * Load the ip controller.
 */
return [
    // Path where to mount the routes, is added to each route path.
    "mount" => "ip",
    "routes" => [
        [
            "info" => "Validate ip-adress.",
            "path" => "",
            "handler" => "\Anax\Controller\IpController",
        ],
        [
            "info" => "Validate ip-adress.",
            "path" => "validate",
            "handler" => "\Anax\Controller\IpController",
        ],
        [
            "info" => "Validate ip-adress.",
            "path" => "json",
            "handler" => "\Anax\Controller\JsonIpController",
        ],
        [
            "info" => "Validate ip-adress.",
            "path" => "testjson",
            "handler" => "\Anax\Controller\JsonIpController",
        ],
        [
            "info" => "Get geographical information from ip-adress.",
            "path" => "geoinfo",
            "handler" => "\Anax\Controller\IpController",
        ],
        [
            "info" => "Get geographical information from ip-adress.",
            "path" => "geojson",
            "handler" => "\Anax\Controller\JsonIpController",
        ],
    ]
];
