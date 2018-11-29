<?php

namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the WeatherController.
 */
class WeatherControllerTest extends TestCase
{
    // Create the di container.
    protected $di;
    protected $controller;



    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;

        // Setup di
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // View helpers uses the global $di so it needs its value
        $di = $this->di;

        // Setup the controller
        $this->controller = new WeatherController();
        $this->controller->setDI($this->di);
        $this->controller->initialize();
    }


    /**
     * Test the route "index".
     */
    public function testIndexAction()
    {
        $res = $this->controller->indexAction();
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "<title>Få väderinformation";
        $this->assertContains($exp, $body);
    }


    /**
     * Test the route "index".
     */
    public function testGetWeatherGetError()
    {
        $this->di->get("request")->setGet("pos", "::1");
        $res = $this->controller->getInfoAction();
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "Kunde inte hämta position utifrån den angivna platsen";
        $this->assertContains($exp, $body);
    }


    /**
     * Test the route "index".
     */
    public function testGetWeatherGetIp()
    {
        $this->di->get("request")->setGet("pos", "123.123.123.123");
        $res = $this->controller->getInfoAction();
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "Prognos (timvis)";
        $this->assertContains($exp, $body);
    }


    /**
     * Test the route "index".
     */
    public function testGetWeatherGetRedirectJson()
    {
        $this->di->get("request")->setGet("pos", "123.123.123.123");
        $this->di->get("request")->setGet("data", "json");
        $res = $this->controller->getInfoAction();
        $this->assertInstanceOf("\Anax\Response\Response", $res);
    }


    // /**
    //  * Test the route "index".
    //  */
    // public function testGetWeatherGetPosition()
    // {
    //     $this->di->get("request")->setGet("pos", "Uppsala");
    //     $res = $this->controller->getInfoAction();
    //     $this->assertInstanceOf("\Anax\Response\Response", $res);

    //     $body = $res->getBody();
    //     $exp = "Prognos (timvis)";
    //     $this->assertContains($exp, $body);
    // }


    /**
     * Test the route "index".
     */
    public function testGetWeatherGetCoords()
    {
        $this->di->get("request")->setGet("pos", "59.8585,17.6454");
        $res = $this->controller->getInfoAction();
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "Prognos (timvis)";
        $this->assertContains($exp, $body);
    }


    /**
     * Test the route "index".
     */
    public function testGetWeatherGetCoordsError()
    {
        $this->di->get("request")->setGet("pos", "1259.8585,1517.6454");
        $res = $this->controller->getInfoAction();
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "Y-koordinaten är utanför maxgränsen.\n";
        $this->assertContains($exp, $body);
    }
}
