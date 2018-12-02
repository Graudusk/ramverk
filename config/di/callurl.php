<?php
/**
 * Configuration file for DI container.
 */
return [
    // Services to add to the container.
    "services" => [
        "callurl" => [
            "shared" => true,
            "callback" => function () {
                $callUrl = new \Erjh17\CallUrl\CallUrl();
                $callUrl->setDI($this);
                return $callUrl;
            }
        ],
    ],
];
