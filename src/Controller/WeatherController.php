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
class WeatherController implements ContainerInjectableInterface
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

        $page->add("anax/v2/weather/index");
        return $page->render(
            [
                "title" => "Få väderinformation",
                "baseTitle" => " | Anax development utilities"
            ]
        );
    }

    /**
     * [getInfoAction description]
     *
     * @return [type] [description]
     */
    public function getInfoAction() : object
    {
        $request = $this->di->get("request");
        $page = $this->di->get("page");

        if ($request->getGet("data") == "json") {
            return $this->di->get("response")->redirect("weather/getjson?pos=" . $request->getGet("pos"));
        }
        $position = $request->getGet("pos");
        $ipm = $this->di->get("callurlmodel");
        if ($position) {
            $ipm->setIpAddress($position);
            $ipm->fetchGeoInfo();
        }

        $page->add("anax/v2/weather/weather-info", $ipm->fetchWeatherInfo());
        return $page->render(
            [
                "title" => "Få väderinformation",
                "baseTitle" => " | Anax development utilities"
            ]
        );
    }



    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint
     * GET METHOD mountpoint/
     * GET METHOD mountpoint/index
     *
     * @return array
     */
    public function getjsonActionGet() : array
    {
        $request = $this->di->get("request");
        $position = $request->getGet("pos");
        $ipm = $this->di->get("callurlmodel");
        $ipm->setIpAddress($position);
        $ipm->fetchGeoInfo();
        return [$ipm->fetchWeatherInfo()];
    }



    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint
     * GET METHOD mountpoint/
     * GET METHOD mountpoint/index
     *
     * @return array
     */
    public function getJsonActionPost() : array
    {
        $request = $this->di->get("request");
        $position = $request->getPost("pos");
        $ipm = $this->di->get("callurlmodel");
        $ipm->setIpAddress($position);
        $ipm->fetchGeoInfo();
        return [$ipm->fetchWeatherInfo()];
    }
}
