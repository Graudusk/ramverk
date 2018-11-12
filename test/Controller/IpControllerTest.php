<?php

namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the IpController.
 */
class IpControllerTest extends TestCase
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
    public function testIndexAction()
    {
        $res = $this->controller->indexAction();
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "<title>Validera Ip-adress";
        $this->assertContains($exp, $body);
    }


    /**
     * Test the route "index".
     */
    public function testValidateGetError()
    {
        $this->di->get("request")->setGet("ip", "1323");
        $res = $this->controller->validateActionGet();
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "1323 är inte en giltig IP adress";
        $this->assertContains($exp, $body);
    }


    /**
     * Test the route "index".
     */
    public function testValidateGetIPv4()
    {
        $this->di->get("request")->setGet("ip", "123.123.123.123");
        $res = $this->controller->validateActionGet();
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "123.123.123.123 är en giltig IPv4 adress";
        $this->assertContains($exp, $body);
    }


    /**
     * Test the route "index".
     */
    public function testValidateGetRedirectJson()
    {
        $this->di->get("request")->setGet("ip", "123.123.123.123");
        $this->di->get("request")->setGet("data", "json");
        $res = $this->controller->validateActionGet();
        $this->assertInstanceOf("\Anax\Response\Response", $res);
    }


    /**
     * Test the route "index".
     */
    public function testValidateGetIPv6()
    {
        $this->di->get("request")->setGet("ip", "2001:0db8:85a3:08d3:1319:8a2e:0370:7334");
        $res = $this->controller->validateActionGet();
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "2001:0db8:85a3:08d3:1319:8a2e:0370:7334 är en giltig IPv6 adress";
        $this->assertContains($exp, $body);
    }
}
