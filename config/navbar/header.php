<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",
 
    // Here comes the menu items
    "items" => [
        [
            "text" => "Hem",
            "url" => "",
            "title" => "Första sidan, börja här.",
        ],
        [
            "text" => "Redovisning",
            "url" => "redovisning",
            "title" => "Redovisningstexter från kursmomenten.",
            "submenu" => [
                "items" => [
                    [
                        "text" => "Kmom01",
                        "url" => "redovisning/kmom01",
                        "title" => "Redovisning för kmom01.",
                    ],
                    [
                        "text" => "Kmom02",
                        "url" => "redovisning/kmom02",
                        "title" => "Redovisning för kmom02.",
                    ],
                    [
                        "text" => "Kmom03",
                        "url" => "redovisning/kmom03",
                        "title" => "Redovisning för kmom03.",
                    ],
                ],
            ],
        ],
        [
            "text" => "Om",
            "url" => "om",
            "title" => "Om denna webbplats.",
        ],
        [
            "text" => "Ip",
            "url" => "ip",
            "title" => "Validera ip-adress.",
            "submenu" => [
                "items" => [
                    [
                        "text" => "Validera",
                        "url" => "ip/validate",
                        "title" => "Validera ip-adress.",
                    ],
                    [
                        "text" => "GeoInfo",
                        "url" => "ip/geoinfo",
                        "title" => "Hämta geografisk info.",
                    ]
                ],
            ],
        ],
        [
            "text" => "Väder",
            "url" => "weather",
            "title" => "API för att hämta väderinformation.",
            "submenu" => [
                "items" => [
                    [
                        "text" => "Hämta info",
                        "url" => "weather/getInfo",
                        "title" => "Hämta väderinformation.",
                    ]/*,
                    [
                        "text" => "GeoInfo",
                        "url" => "weather/geoinfo",
                        "title" => "Hämta geografisk info.",
                    ]*/
                ],
            ],
        ],
        [
            "text" => "Verktyg",
            "url" => "verktyg",
            "title" => "Verktyg och möjligheter för utveckling.",
        ],
    ],
];
