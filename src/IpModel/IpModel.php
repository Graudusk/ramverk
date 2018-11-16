<?php
/**
 * Showing off a standard class with methods and properties.
 */
namespace Anax\IpModel;

class IpModel
{
    use IpModelGeoTrait;
    /**
     * @var int        $ipAddress  The ip address.
     * @var string     $message  The message.
     * @var boolean    $valid  If the ip address is valid.
     * @var string     $host  The ip adress' host.
     */

    private $ipAddress;
    private $message;
    private $valid;
    private $host;
    /**
     * Constructor to create a Dice.
     *
     * @param int    $sides  The number of sides of the Dice.
     * @param int    $tossed  The number of times Dice has been tossed.
     * @param int    $sum  The sum of the dice rolls.
     */
    public function __construct(string $ipAddress = null)
    {
        $this->ipAddress = trim($ipAddress);
    }

    public function getInfo()
    {
        return array(
            'ip' => $this->ipAddress,
            'host' => $this->host,
            'message' => $this->message,
            'valid' => $this->valid
        );
    }

    public function validateIp()
    {
        if ($this->ipAddress) {
            if (filter_var($this->ipAddress, FILTER_VALIDATE_IP)) {
                $this->valid = true;
                if (filter_var($this->ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                    $this->message = "$this->ipAddress är en giltig IPv4 adress";
                    $this->host = gethostbyaddr($this->ipAddress);
                } elseif (filter_var($this->ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                    $this->message = "$this->ipAddress är en giltig IPv6 adress";
                }
            } else {
                $this->message = "$this->ipAddress är inte en giltig IP adress";
            }
        }
        return $this->getInfo();
    }
}
