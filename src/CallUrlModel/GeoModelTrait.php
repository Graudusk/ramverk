<?php
/**
 * Showing off a standard class with methods and properties.
 */
namespace Erjh17\CallUrlModel;

/**
 * A trait implementing GeoModelTrait.
 */
trait GeoModelTrait
{
    // use \Erjh17\CallUrl;
    /**
     * @var int        $ip  The ip address.
     * @var string     $message  The message.
     * @var boolean    $valid  If the ip address is valid.
     * @var string     $host  The ip adress' host.
     */

    private $continent_name;
    private $country_name;
    private $city;
    private $zip;
    private $latitude;
    private $ipUrl;
    private $longitude;
    private $openCageUrl;
    private $opencagekey;
    public $dataList = [
        "continent_name",
        "country_name",
        "city",
        "zip",
        "latitude",
        "longitude",
        "lat",
        "lon",
        "display_name"
    ];

    /**
     * Sets opencagekey property.
     *
     * @param string $url opencage url.
     */
    public function setOpencageUrl($url)
    {
        $this->openCageUrl = $url;
    }

    /**
     * Sets opencagekey property.
     *
     * @param string $key opencage key.
     */
    public function setOpencageKey($key)
    {
        $this->opencagekey = $key;
    }

    /**
     * Returns specific fetched key properties.
     *
     * @return [array] Geographic data
     */
    public function getGeoInfo()
    {
        return array_merge(
            array(
                'continent_name' => $this->continent_name,
                'country_name' => $this->country_name,
                'city' => $this->city,
                'zip' => $this->zip,
                'latitude' => str_replace(",", ".", $this->latitude),
                'longitude' => str_replace(",", ".", $this->longitude),
                'mapUrl' => "https://www.openstreetmap.org/#map=12/$this->latitude/$this->longitude&layers=H"
            ),
            $this->getZoomLevel()
        );
    }

    /**
     * Calculates zoom level and radius for the map and returns it.
     *
     * @return array Array containing zoom level and marker radius.
     */
    public function getZoomLevel()
    {
        $retArray;
        if (!$this->isValidIp()) {
            $retArray = array("zoomLevel" => "12", "radius" => "600");
        } elseif ($this->city !== null) {
            $retArray = array("zoomLevel" => "12", "radius" => "600");
        } else {
            $retArray = array("zoomLevel" => "3", "radius" => "400000");
        }
        return $retArray;
    }

    /**
     * Returns geographic info together with IP-info
     *
     * @return array Ip-info + geographic info
     */
    public function getAllInfo()
    {
        return array_merge($this->getInfo(), $this->getGeoInfo());
    }

    /**
     * Validates provided coordinate with regexp.
     *
     * @param string $subject Coordinate.
     *
     * @return boolean
     */
    public function isCoord($subject)
    {
        $pattern = "/\d+\.\d+[\,\ ]+\d+\.\d+/";
        return preg_match($pattern, $subject);
    }

    /**
     * Fetches geographic information from callUrl module using ip address.
     *
     * @return array Data array with geographic info.
     */
    public function getGeoFromIp()
    {
        $cUrl = $this->di->get("callurl");
        $query = ["access_key" => $this->ipstackkey];
        $url = $this->ipUrl . $this->ipAddress;
        return $cUrl->fetch($url, $query);
    }

    /**
     * Fetches and returns Geographic info from multiple sources.
     *
     * @return array Geographic data.
     */
    public function fetchGeoInfo()
    {
        $cUrl = $this->di->get("callurl");
        $this->validateIp();
        if (!$this->isValidIp() && $this->isCoord($this->ipAddress)) {
            $this->setCoord();
        } elseif ($this->isValidIp()) {
            $apiResult = $this->getGeoFromIp();

            if ($apiResult) {
                $this->fillInfo($apiResult, $this->dataList);
            } else {
                $this->setErrorMessage("Ingen positionsdata kunde hämtas utifrån platsnamnet.");
            }
        } else {
            $query = [
                "key" => $this->opencagekey,
                "q" => $this->ipAddress,
                "pretty" => "1",
                "language" => "sv"
            ];
            $url = $this->openCageUrl;
            $geocode = $cUrl->fetch($url, $query);

            if (isset($geocode["results"][0])) {
                $this->latitude = $geocode["results"][0]["geometry"]["lat"];
                $this->longitude = $geocode["results"][0]["geometry"]["lng"];
                $nodeType = $geocode["results"][0]["components"]["_type"];
                if (isset($geocode["results"][0]["components"][$nodeType])) {
                    $this->city = $geocode["results"][0]["components"][$nodeType];
                }
                if (isset($geocode["results"][0]["components"]["country"])) {
                    $this->country_name = $geocode["results"][0]["components"]["country"];
                }
                if (isset($geocode["results"][0]["components"]["postcode"])) {
                    $this->zip = $geocode["results"][0]["components"]["postcode"];
                }
            } else {
                $this->setErrorMessage("Ingen positionsdata kunde hämtas utifrån platsnamnet.");
            }
        }
        $this->validateCoord();
        return $this->getAllInfo();
    }


    /**
     * Sets the error message provided.
     *
     * @param string $msg Error message
     */
    public function setErrorMessage($msg)
    {
        $this->errorMsg .= $msg . "\n";
    }

    /**
     * Checks wether the coordinate is within the map bounds
     *
     * @return boolean
     */
    public function validateCoord()
    {
        $lat = str_replace(".", ",", $this->latitude);
        $lon = str_replace(".", ",", $this->longitude);
        if (!$lat && !$lon) {
            $this->setErrorMessage("Kunde inte hämta position utifrån den angivna platsen.");
        }
        if ($lat < -85.05112878 || $lat > 85.05112878) {
            $this->setErrorMessage("Y-koordinaten är utanför maxgränsen.");
        }
        if ($lon < -180 || $lon > 180) {
            $this->setErrorMessage("X-koordinaten är utanför maxgränsen.");
        }
    }

    /**
     * Turns the provided string into a map coordinate.
     *
     * @return void
     */
    public function setCoord()
    {
        if ($this->ipAddress) {
            $latLon = explode(",", $this->ipAddress);
            $this->latitude = $latLon[0];
            $this->longitude = $latLon[1];
        }
    }
}
