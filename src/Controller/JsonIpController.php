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
        $message = "";
        $ipNumber = "";
        $server = "";
        $valid = false;

        if ($request->getGet("ip")) {
            $ipNumber = trim($request->getGet("ip"));

            if (filter_var($ipNumber, FILTER_VALIDATE_IP)) {
                $valid = true;
                if (filter_var($ipNumber, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                    $message = "$ipNumber är en giltig IPv4 adress";
                    $server = gethostbyaddr($ipNumber);
                } elseif (filter_var($ipNumber, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                    $message = "$ipNumber är en giltig IPv6 adress";
                }
            } else {
                $message = "$ipNumber är inte en giltig IP adress";
            }
        }
        $json = [
            "ip" => $ipNumber,
            "message" => $message,
            "valid" => $valid,
            "host" => $server
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
    public function jsonActionPost() : array
    {
        // Deal with the action and return a response.

        $request = $this->di->get("request");
        $message = "";
        $ipNumber = "";
        $server = "";
        $valid = false;

        if ($request->getPost("ip")) {
            $ipNumber = trim($request->getPost("ip"));

            if (filter_var($ipNumber, FILTER_VALIDATE_IP)) {
                $valid = true;
                // $ipNumbertolocation = 'https://www.iplocate.io/api/lookup/' . $ipNumber;
                // $server = file_get_contents($ipNumbertolocation);
                if (filter_var($ipNumber, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                    $message = "$ipNumber är en giltig IPv4 adress";
                    $server = gethostbyaddr($ipNumber);
                } elseif (filter_var($ipNumber, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                    $message = "$ipNumber är en giltig IPv6 adress";
                }
            } else {
                $message = "$ipNumber är inte en giltig IP adress";
            }
        }
        $json = [
            "ip" => $ipNumber,
            "message" => $message,
            "valid" => $valid,
            "host" => $server
        ];
        return [$json];
    }
}
