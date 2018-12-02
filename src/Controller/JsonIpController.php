<?php

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample JSON controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 */
class JsonIpController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->db = "active";
    }



    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint
     * GET METHOD mountpoint/
     * GET METHOD mountpoint/index
     *
     * @return array
     */
    public function testJsonActionGet() : array
    {
        // Deal with the action and return a response.
        $json = [
            "message" => __METHOD__ . ", \$db is {$this->db}",
        ];
        return [$json];
    }



    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint
     * GET METHOD mountpoint/
     * GET METHOD mountpoint/index
     *
     * @return array
     */
    public function jsonActionGet() : array
    {
        $request = $this->di->get("request");
        $ipm = $this->di->get("callurlmodel");
        $ipm->setIpAddress($request->getGet("ip"));
        return [$ipm->validateIp()];
    }



    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint
     * GET METHOD mountpoint/
     * GET METHOD mountpoint/index
     *
     * @return array
     */
    public function jsonActionPost() : array
    {
        $request = $this->di->get("request");
        $ipm = $this->di->get("callurlmodel");
        $ipm->setIpAddress($request->getPost("ip"));
        return [$ipm->validateIp()];
    }



    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint
     * GET METHOD mountpoint/
     * GET METHOD mountpoint/index
     *
     * @return array
     */
    public function geojsonActionGet() : array
    {
        $request = $this->di->get("request");
        $client = $request->getServer('REMOTE_ADDR');
        $ipaddress = $request->getGet("ip") ? $request->getGet("ip") : $client;
        $ipm = $this->di->get("callurlmodel");
        $ipm->setIpAddress($ipaddress);
        return [$ipm->fetchGeoInfo()];
    }



    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint
     * GET METHOD mountpoint/
     * GET METHOD mountpoint/index
     *
     * @return array
     */
    public function geoJsonActionPost() : array
    {
        $request = $this->di->get("request");
        $client = $request->getServer('REMOTE_ADDR');
        $ipaddress = $request->getPost("ip") ? $request->getPost("ip") : $client;
        $ipm = $this->di->get("callurlmodel");
        $ipm->setIpAddress($ipaddress);
        return [$ipm->fetchGeoInfo()];
    }
}
