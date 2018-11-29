<?php
/**
 * Configuration file for DI container.
 */
return [

    // Services to add to the container.
    "services" => [
        "ipmodel" => [
            "shared" => true,
            "callback" => function () {
                $ipModel = new \Erjh17\IpModel\IpModel();
                $ipModel->setDI($this);

                // Load the configuration files
                $cfg = $this->get("configuration");
                $config = $cfg->load("ipmodel.php");
                $file = $config["file"] ?? null;
                $config = $config["config"] ?? null;

                $ipstackkey = $config["ipstackkey"] ?? null;
                $darkskykey = $config["darkskykey"] ?? null;
                $opencagekey = $config["opencagekey"] ?? null;

                if (!$ipstackkey) {
                    throw new Exception("Configuration file '$file': Missing api key for Ip Stack.");
                } elseif (!$darkskykey) {
                    throw new Exception("Configuration file '$file': Missing api key for Dark Sky.");
                }

                $ipModel->setIpstackKey($ipstackkey);
                $ipModel->setDarkskyKey($darkskykey);
                $ipModel->setOpencageKey($opencagekey);

                return $ipModel;
            }
        ],
    ],
];
