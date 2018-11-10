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
     * @return string
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $response = $this->di->get("response");
        $request = $this->di->get("request");
        $session = $this->di->get("session");
        $content = "";
        $ip = "";
        $server = "";
        if ($request->getGet("ip")) {
            $ip = trim($request->getGet("ip"));

            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                // $iptolocation = 'https://www.iplocate.io/api/lookup/' . $ip;
                // $server = file_get_contents($iptolocation);
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                    $content = "$ip är en giltig IPv4 adress";
                    $server = gethostbyaddr($ip);
                } elseif (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                    $content = "$ip är en giltig IPv6 adress";
                }
            } else {
                $content = "$ip är inte en giltig IP adress";
            }
        }

        $page->add("anax/v2/ip/validate", 
            [
                "content" => $content,
                "ip" => $ip,
                "server" => $server
            ]
        );
        return $page->render(
            [
                "title" => "Validera Ip-adress",
                "baseTitle" => " | Anax development utilities"
            ]
        );
    }
}
