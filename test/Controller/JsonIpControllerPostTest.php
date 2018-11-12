<?php

namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the IpController.
 */
class JsonIpControllerPostTest extends TestCase
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
        $this->controller = new JsonIpController();
        $this->controller->setDI($this->di);
        $this->controller->initialize();
    }



    /**
     * Test the route "index".
     */
    public function testValidatePostJsonError()
    {
        $this->di->get("request")->setGlobals(
            [
                'post' => [
                    'ip' => "1323"
                ]
            ]
        );
        $res = $this->controller->jsonActionPost();
        $this->assertInternalType("array", $res);

        $json = $res[0];
        $exp = "1323 är inte en giltig IP adress";
        $this->assertContains($exp, $json["message"]);
    }


    /**
     * Test the route "index".
     */
    public function testValidatePostIPv4Json()
    {
        $this->di->get("request")->setGlobals(
            [
                'post' => [
                    'ip' => "123.123.123.123"
                ]
            ]
        );
        $res = $this->controller->jsonActionPost();
        $this->assertInternalType("array", $res);

        $json = $res[0];
        $exp = "123.123.123.123 är en giltig IPv4 adress";
        $this->assertContains($exp, $json["message"]);
    }


    /**
     * Test the route "index".
     */
    public function testValidatePostIPv6Json()
    {
        $this->di->get("request")->setGlobals(
            [
                'post' => [
                    'ip' => "2001:0db8:85a3:08d3:1319:8a2e:0370:7334"
                ]
            ]
        );
        $res = $this->controller->jsonActionPost();
        $this->assertInternalType("array", $res);

        $json = $res[0];
        $exp = "2001:0db8:85a3:08d3:1319:8a2e:0370:7334 är en giltig IPv6 adress";
        $this->assertContains($exp, $json["message"]);
    }
}
