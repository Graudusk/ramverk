<?php

namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the IpController.
 */
class WeatherJsonIpControllerPostTest extends TestCase
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
    public function testGetWeatherPostJsonError()
    {
        $this->di->get("request")->setGlobals(
            [
                'post' => [
                    'ip' => "::1"
                ]
            ]
        );
        $res = $this->controller->getJsonActionPost();
        $this->assertInternalType("array", $res);

        $json = $res[0];
        $exp = "Kunde inte hämta position utifrån den angivna platsen.\n";
        $this->assertContains($exp, $json["errorMsg"]);
    }


    // /**
    //  * Test the route "index".
    //  */
    // public function testGetWeatherPostIpJson()
    // {
    //     $this->di->get("request")->setGlobals(
    //         [
    //             'post' => [
    //                 'pos' => "123.123.123.123"
    //             ]
    //         ]
    //     );
    //     $res = $this->controller->getJsonActionPost();
    //     $this->assertInternalType("array", $res);

    //     $json = $res[0];
    //     $exp = "icon";
    //     $this->assertArrayHasKey($exp, $json["currently"]);
    // }


    // /**
    //  * Test the route "index".
    //  */
    // public function testGetWeatherPostPositionJson()
    // {
    //     $this->di->get("request")->setGlobals(
    //         [
    //             'post' => [
    //                 'pos' => "uppsala"
    //             ]
    //         ]
    //     );
    //     $res = $this->controller->getJsonActionPost();
    //     $this->assertInternalType("array", $res);

    //     $json = $res[0];
    //     $exp = "icon";
    //     $this->assertContains($exp, $json["currently"]);
    // }


    /**
     * Test the route "index".
     */
    // public function testGetWeatherPostCoordJson()
    // {
    //     $this->di->get("request")->setGlobals(
    //         [
    //             'post' => [
    //                 'pos' => "59.8585,17.6454"
    //             ]
    //         ]
    //     );
    //     $res = $this->controller->getJsonActionPost();
    //     $this->assertInternalType("array", $res);

    //     $json = $res[0];
    //     $exp = "icon";
    //     $this->assertContains($exp, $json["currently"]);
    // }
}
