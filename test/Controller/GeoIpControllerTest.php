<?php

namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the IpController.
 */
class GeoIpControllerTest extends TestCase
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
        $this->controller = new IpController();
        $this->controller->setDI($this->di);
        $this->controller->initialize();
    }


    /**
     * Test the route "index".
     */
    public function testGetGeoGetError()
    {
        $this->di->get("request")->setGet("ip", "::1");
        $res = $this->controller->geoInfoActionGet();
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "Ingen geografisk data kunde hittas";
        $this->assertContains($exp, $body);
    }


    /**
     * Test the route "index".
     */
    public function testGetGeoGetIPv4()
    {
        $this->di->get("request")->setGet("ip", "123.123.123.123");
        $res = $this->controller->geoInfoActionGet();
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "123.123.123.123 är en giltig IPv4 adress";
        $this->assertContains($exp, $body);
    }


    /**
     * Test the route "index".
     */
    public function testGetGeoGetRedirectJson()
    {
        $this->di->get("request")->setGet("ip", "123.123.123.123");
        $this->di->get("request")->setGet("data", "json");
        $res = $this->controller->geoInfoActionGet();
        $this->assertInstanceOf("\Anax\Response\Response", $res);
    }


    /**
     * Test the route "index".
     */
    public function testGetGeoGetIPv6()
    {
        $this->di->get("request")->setGet("ip", "2001:0db8:85a3:08d3:1319:8a2e:0370:7334");
        $res = $this->controller->geoInfoActionGet();
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "2001:0db8:85a3:08d3:1319:8a2e:0370:7334 är en giltig IPv6 adress";
        $this->assertContains($exp, $body);
    }
}
