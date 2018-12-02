<?php
/**
 * Showing off a standard class with methods and properties.
 */
namespace Erjh17\CallUrlModel;

/**
 * A trait implementing WeatherModelTrait.
 */
trait WeatherModelTrait
{
    /**
     * Class handling logic for fetching and parsing weather data from API calls.
     *
     * @var int        $ip  The ip address.
     * @var string     $message  The message.
     * @var boolean    $valid  If the ip address is valid.
     * @var string     $host  The ip adress' host.
     */

    private $position;
    private $darkSkyUrl;
    private $currently;
    private $hourly;
    private $daily;
    private $pastDays;
    private $darkskykey;

    /**
     * Sets darkskykey property.
     *
     * @param string $url darksky url.
     */
    public function setDarkskyUrl($url)
    {
        $this->darkSkyUrl = $url;
    }

    /**
     * Sets darkskykey property.
     *
     * @param string $key darksky key.
     */
    public function setDarkskyKey($key)
    {
        $this->darkskykey = $key;
    }

    /**
     * Get darkskykey property.
     *
     * @return string $key darksky key.
     */
    public function getDarkskyKey()
    {
        return $this->darkskykey;
    }

    /**
     * Returns specific fetched key properties.
     *
     * @return [array] Weather data
     */
    public function getWeatherInfo()
    {
        if ($this->currently !== null) {
            return array_merge(
                $this->getInfo(),
                $this->getGeoInfo(),
                array(
                    "pos" => $this->ipAddress,
                    "positionName" => $this->getPosition(),
                    "currently" => $this->currently(),
                    "hours" => $this->hourly(),
                    "days" => $this->daily(),
                    "pastDays" => $this->pastDays(),
                    "script" => $this->generateScript()
                )
            );
        } else {
            return array_merge(
                $this->getInfo(),
                array(
                    "pos" => $this->ipAddress
                )
            );
        }
    }

    /**
     * Sets the position property according to available properties.
     *
     * @return string Position string
     */
    public function getPosition()
    {
        $positionName = $this->ipAddress;
        if ($this->city) {
            $placeNames = array($this->city);
            if ($this->country_name) {
                array_push($placeNames, $this->country_name);
            }
            $positionName = implode(", ", $placeNames);
        } elseif ($this->latitude && $this->longitude) {
            $positionName = $this->latitude . ", " . $this->longitude;
        }
        return $positionName;
    }

    /**
     * Parses and returns the weather data for the current day
     *
     * @return array Parsed weather data.
     */
    public function currently()
    {
        $currently = [];
        setlocale(LC_ALL, 'sv_SV');
        if ($this->currently && $this->currently["time"]) {
            $currently = $this->pushInfo(
                $this->currently,
                [
                    "weekday",
                    "date",
                    "timeofday",
                    "icon",
                    "temperature",
                    "apparentTemperature",
                    "summary",
                    "windSpeed",
                    "precipProbability",
                    "pressure"
                ]
            );

            $time = $this->currently["time"];
            $localdate = strftime(self::DATE_FORMAT, $time);
            $localtime = strftime(self::TIME_FORMAT, $time);
            $weekday = strftime(self::DAY_FORMAT, $time);

            $currently["weekday"] = ucfirst($weekday);
            $currently["date"] = ucfirst($localdate);
            $currently["timeofday"] = ucfirst($localtime);
        }
        return $currently;
    }


    public function generateScript()
    {
        $zoomLevel = $this->getZoomLevel();

        $latitude = str_replace(",", ".", $this->latitude);
        $longitude = str_replace(",", ".", $this->longitude);
        $zLevel = $zoomLevel["zoomLevel"];
        $radius = $zoomLevel["radius"];
        $script = "    window.addEventListener('load', function() {".
            "        window.initMap($longitude, $latitude, $zLevel, $radius);".
            "        var skycons = new Skycons({'color': 'white'});";
        $icon = $this->currently['icon'];
        $script .= "        skycons.add('icon1', '$icon');";
        foreach ($this->daily["data"] as $day) {
            $time = $day['time'];
            $icon = $day['icon'];
            $script .= "skycons.add('icon$time', '$icon');";
        }
        $script .= "        skycons.play();".
        "    });";
        return $script;
    }

    /**
     * Parses and returns the weather data for coming hours
     *
     * @return array Parsed weather data.
     */
    public function hourly()
    {
        $hourly = [];
        if ($this->hourly && isset($this->hourly["data"])) {
            $this->hourly["data"] = array_slice($this->hourly["data"], 0, 12);
            for ($i=0; $i < sizeof($this->hourly["data"]); $i++) {
                setlocale(LC_ALL, 'sv_SV');
                $time = $this->hourly["data"][$i]["time"];
                if ($time) {
                    $this->parseDate("hourly", $i, $time);
                    $weekday = strftime(self::DAY_FORMAT, $time);
                    $weeknr = strftime("%w", $time);

                    $hourly["days"][$weeknr]["hours"][$i] = $this->pushInfo(
                        $this->hourly["data"][$i],
                        [
                            "icon",
                            "timeofday",
                            "summary",
                            "temperature",
                            "apparentTemperature",
                            "date",
                            "weekday",
                            "timeofday"
                        ]
                    );
                    $hourly["days"][$weeknr]["day"] = ucfirst($weekday);
                }
            }
        }
        return $hourly;
    }

    /**
     * Parses and returns the weather data for the past days
     *
     * @return array Parsed weather data.
     */
    public function pastDays()
    {
        $pastDays = [];

        if ($this->pastDays["data"]) {
            setlocale(LC_ALL, 'sv_SV');
            for ($i=0; $i < sizeof($this->pastDays["data"]); $i++) {
                $time = $this->pastDays["data"][$i]["time"];
                if ($time) {
                    $this->parseDate("pastDays", $i, $time);
                    $pastDays[$i] = $this->pushInfo(
                        $this->pastDays["data"][$i],
                        [
                            "icon",
                            "weekday",
                            "date",
                            "summary",
                            "temperatureMax",
                            "apparentTemperatureMax",
                            "temperatureMin",
                            "apparentTemperatureMin",
                            "time"
                        ]
                    );
                }
            }
        }
        return $pastDays;
    }

    /**
     * Parses weather data and creates date and time data and returns them.
     *
     * @param string  $arr  string representing the property
     *                      to be called from '$this'
     * @param integer $i    array index in target data object
     * @param int     $time Unix time integer
     *
     * @return void
     */
    public function parseDate($arr, $i, $time)
    {
        $localdate = strftime(self::DATE_FORMAT, $time);
        $localtime = strftime(self::TIME_FORMAT, $time);
        $weekday = strftime(self::DAY_FORMAT, $time);
        $this->$arr["data"][$i]["date"] = $localdate;
        $this->$arr["data"][$i]["weekday"] = ucfirst($weekday);
        $this->$arr["data"][$i]["timeofday"] = $localtime;
        $this->$arr["days"][strftime("%w", $time)]["hours"][$i] = $this->$arr["data"][$i];
        $this->$arr["days"][strftime("%w", $time)]["day"] = ucfirst($weekday);
    }

    /**
     * Parses and returns the weather data for the coming days
     *
     * @return array Parsed weather data.
     */
    public function daily()
    {
        $days = [];
        if ($this->daily) {
            $this->daily["data"] = array_slice($this->daily["data"], 1, 30);
            setlocale(LC_ALL, 'sv_SV');
            for ($i=0; $i < sizeof($this->daily["data"]); $i++) {
                $time = $this->daily["data"][$i]["time"];
                if ($time) {
                    $this->parseDate("daily", $i, $time);
                    $days[$i] = $this->pushInfo(
                        $this->daily["data"][$i],
                        [
                            "weekday",
                            "date",
                            "icon",
                            "summary",
                            "temperatureMax",
                            "apparentTemperatureMax",
                            "temperatureMin",
                            "apparentTemperatureMin",
                            "time"
                        ]
                    );
                }
            }
        }
        return $days;
    }

    /**
     * Creates array containing dates ranging 30 days back
     *
     * @return array Dates
     */
    public function calculateTimeMachine()
    {
        $days = array();
        for ($i=1; $i < 31; $i++) {
            $date = date('c', strtotime("-$i days"));
            array_push($days, strtotime($date));
        }
        return $days;
    }

    /**
     * Creates the arguments to go into the batch call
     *
     * @return array Array containing urls, parameters and query strings
     */
    public function buildArgs()
    {
        $time = $this->calculateTimeMachine();

        $urls = array($this->darkSkyUrl);
        $params = array(
            array($this->getDarkskyKey(), $this->latitude . "," . $this->longitude)
        );
        $queries = array(
            array("lang" => "sv", "units" => "si")
        );

        // var_dump($this->darkSkyUrl);

        foreach ($time as $day) {
            array_push($urls, $this->darkSkyUrl);
            array_push(
                $params,
                array(
                    $this->getDarkskyKey(),
                    $this->latitude . "," . $this->longitude . "," . $day
                )
            );
            array_push(
                $queries,
                array(
                    "lang" => "sv",
                    "units" => "si",
                    "exclude" => "currently,flags,hourly"
                )
            );
        }
        return [
            "urls" => $urls,
            "params" => $params,
            "queries" => $queries
        ];
    }

    /**
     * Batch API-calls to get weather data
     *
     * @return array Weather data
     */
    public function fetchWeatherInfo()
    {
        if ($this->latitude && $this->latitude) {
            $cUrl = $this->di->get("callurl");
            $args = $this->buildArgs();
            $apiResult = $cUrl->fetchConcurrently(
                $args["urls"],
                $args["params"],
                $args["queries"]
            );

            if (isset($apiResult[0]["error"])) {
                $this->setErrorMessage("DarkSkyError: " . $apiResult[0]['error']);
            }

            $pastDays = array("data" => []);
            for ($i=1; $i < sizeof($apiResult); $i++) {
                if ($apiResult[$i] && isset($apiResult[$i]["daily"]["data"][0])) {
                    array_push($pastDays["data"], $apiResult[$i]["daily"]["data"][0]);
                }
            }

            // var_dump($apiResult);

            if ($apiResult[0]) {
                $this->fillInfo(
                    array_merge($apiResult[0], array("pastDays" => $pastDays)),
                    [
                        "currently",
                        "hourly",
                        "daily",
                        "pastDays"
                    ]
                );
            } else {
                $this->setErrorMessage("DarkSkyError: daily usage limit exceeded");
            }
        }
        return $this->getWeatherInfo();
    }
}
