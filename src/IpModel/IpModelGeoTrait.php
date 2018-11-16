<?php
/**
 * Showing off a standard class with methods and properties.
 */
namespace Anax\IpModel;

/**
 * A trait implementing IpModelGeoTrait.
 */
trait IpModelGeoTrait
{
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
    private $longitude;

    public function getGeoInfo()
    {
        return array(
            'continent_name' => $this->continent_name,
            'country_name' => $this->country_name,
            'city' => $this->city,
            'zip' => $this->zip,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude
        );
    }

    public function fillInfo($result, $arr)
    {
        foreach ($arr as $value) {
            if (array_key_exists($value, $result)) {
                $this->$value = $result[$value];
            }
        }
    }

    public function getAllInfo()
    {
        return array_merge($this->getInfo(), $this->getGeoInfo());
    }

    public function fetchGeoInfo()
    {
        $this->validateIp();
        if ($this->valid) {
            // Initialize CURL:
            $accessKey = file_get_contents(__DIR__ . "/.apikey");
            $apiGet = curl_init('http://api.ipstack.com/'.$this->ipAddress.'?access_key='.$accessKey.'');
            curl_setopt($apiGet, CURLOPT_RETURNTRANSFER, true);

            // Store the data:
            $json = curl_exec($apiGet);
            curl_close($apiGet);

            // Decode JSON response:
            $apiResult = json_decode($json, true);

            $this->fillInfo($apiResult, [
                "continent_name",
                "country_name",
                "city",
                "zip",
                "latitude",
                "longitude"
            ]);
        }
        return $this->getAllInfo();
    }
}
