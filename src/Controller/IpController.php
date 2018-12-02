<?php

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class IpController implements ContainerInjectableInterface
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
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function indexAction() : object
    {
        // Deal with the action and return a response.
        $page = $this->di->get("page");

        $page->add("anax/v2/ip/index");
        return $page->render(
            [
                "title" => "Validera Ip-adress",
                "baseTitle" => " | Anax development utilities"
            ]
        );
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function validateActionGet() : object
    {
        $page = $this->di->get("page");
        $request = $this->di->get("request");
        if ($request->getGet("data") == "json") {
            return $this->di->get("response")->redirect("ip/json?ip=" . $request->getGet("ip"));
        }
        $client = $request->getServer('REMOTE_ADDR');
        $ipAddress = $request->getGet("ip") ? $request->getGet("ip") : $client;

        $ipm = $this->di->get("callurlmodel");
        $ipm->setIpAddress($ipAddress);

        $page->add("anax/v2/ip/validate", $ipm->validateIp());
        return $page->render(
            [
                "title" => "Validera Ip-adress",
                "baseTitle" => " | Anax development utilities"
            ]
        );
    }


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function geoInfoActionGet() : object
    {
        $page = $this->di->get("page");
        $request = $this->di->get("request");
        if ($request->getGet("data") == "json") {
            return $this->di->get("response")->redirect("ip/geojson?ip=" . $request->getGet("ip"));
        }
        $ipAddress = $request->getGet("ip") ? $request->getGet("ip") : $request->getServer('REMOTE_ADDR');
        $ipm = $this->di->get("callurlmodel");
        $ipm->setIpAddress($ipAddress);
        $page->add("anax/v2/ip/geo-info", $ipm->fetchGeoInfo());
        return $page->render(
            [
                "title" => "Hämta geografisk information från Ip-adress",
                "baseTitle" => " | Anax development utilities"
            ]
        );
    }
}
