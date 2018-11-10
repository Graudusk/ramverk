<?php
/**
 * Load the ip controller.
 */
return [
    // Path where to mount the routes, is added to each route path.
    "routes" => [
        [
            "info" => "Validate ip-adress.",
            "mount" => "ip",
            "handler" => "\Anax\Controller\IpController",
        ],
    ]
];
